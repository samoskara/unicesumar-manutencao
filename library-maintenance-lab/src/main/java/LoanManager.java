import java.util.List;
import java.util.Map;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

public class LoanManager {

    private static final Logger logger = LogManager.getLogger(LoanManager.class);

    private static final String FIELD_AVAILABLE_COPIES = "availableCopies";
    private static final String FIELD_BOOK_ID = "bookId";
    private static final String FIELD_BORROW_DATE = "borrowDate";
    private static final String FIELD_DEBT = "debt";
    private static final String FIELD_DUE_DATE = "dueDate";
    private static final String FIELD_FINE = "fine";
    private static final String FIELD_ID = "id";
    private static final String FIELD_RETURNED_DATE = "returnedDate";
    private static final String FIELD_STATUS = "status";
    private static final String FIELD_TOTAL_COPIES = "totalCopies";
    private static final String FIELD_USER_ID = "userId";

    private static final String STATUS_ACTIVE = "ACTIVE";
    private static final String STATUS_OPEN = "OPEN";
    private static final String STATUS_CLOSED = "CLOSED";

    private static final String CHANNEL_EMAIL = "email";
    private static final String CHANNEL_SMS = "sms";

    private static final String EMPTY_VALUE = "";
    private static final String LOAN_CREATED_NOTE = "loan-created";
    private static final String LOAN_CREATED_SYNC_NOTE = "loan-created-sync";
    private static final String LOAN_NOTIFICATION_TEMPLATE = "TPL1";
    private static final String LOAN_NOTIFICATION_MANAGER = "manager";
    private static final String PROCESS_CLI = "cli";
    private static final String RETURN_HANDLER = "handler";

    private static final double MAX_ALLOWED_DEBT = 100.0;
    private static final int MAX_OPEN_LOANS_BY_USER = 5;
    private static final int POLICY_CODE_SPECIAL_7 = 7;
    private static final int POLICY_CODE_SPECIAL_8 = 8;

    private NotificationService notificationService = new NotificationService();

    public int borrowBook(BorrowRequest request) {
        try {
            Map<String, Object> user = findUserForBorrow(request.getUserId());
            Map<String, Object> book = findBookForBorrow(request.getBookId());

            validateBorrowRules(request, user, book);

            String borrowDate = resolveBorrowDate(request);
            String dueDate = resolveDueDate(request, borrowDate);
            int loanId = createOpenLoan(request, borrowDate, dueDate);

            createSmsSyncLoanIfNeeded(request, borrowDate, dueDate);
            decreaseAvailableCopies(book);
            notifyLoanCreated(request, borrowDate, dueDate);
            logLoanPolicy(request);
            LegacyDatabase.addLog("loan-created-ok-" + loanId);

            return loanId;
        } catch (Exception e) {
            LegacyDatabase.addLog("borrow-error-" + e.getMessage());
            throw new RuntimeException("Cannot borrow book now");
        }
    }

    private Map<String, Object> findUserForBorrow(int userId) {
        Map<String, Object> user = LegacyDatabase.getUserById(userId);
        if (user == null) {
            throw new RuntimeException("User not found");
        }
        return user;
    }

    private Map<String, Object> findBookForBorrow(int bookId) {
        Map<String, Object> book = LegacyDatabase.getBookById(bookId);
        if (book == null) {
            throw new RuntimeException("Book not found");
        }
        return book;
    }

    private void validateBorrowRules(BorrowRequest request, Map<String, Object> user, Map<String, Object> book) {
        if (!STATUS_ACTIVE.equals(String.valueOf(user.get(FIELD_STATUS)))) {
            throw new RuntimeException("User not active");
        }
        if (((Double) user.get(FIELD_DEBT)).doubleValue() > MAX_ALLOWED_DEBT) {
            throw new RuntimeException("User debt too high");
        }
        if (((Integer) book.get(FIELD_AVAILABLE_COPIES)).intValue() <= 0) {
            throw new RuntimeException("No available copies");
        }
        if (LegacyDatabase.countOpenLoansByUser(request.getUserId()) >= MAX_OPEN_LOANS_BY_USER) {
            throw new RuntimeException("User has too many open loans");
        }
        if (LegacyDatabase.countOpenLoansByBook(request.getBookId()) >= ((Integer) book.get(FIELD_TOTAL_COPIES)).intValue()) {
            throw new RuntimeException("No book copies by open loan count");
        }
    }

    private String resolveBorrowDate(BorrowRequest request) {
        if (DataUtil.isBlank(request.getBorrowDate())) {
            return DataUtil.nowDate();
        }
        return request.getBorrowDate();
    }

    private String resolveDueDate(BorrowRequest request, String borrowDate) {
        if (DataUtil.isBlank(request.getDueDate())) {
            return DataUtil.datePlusDaysApprox(borrowDate, request.getMaxDays());
        }
        return request.getDueDate();
    }

    private int createOpenLoan(BorrowRequest request, String borrowDate, String dueDate) {
        return LegacyDatabase.addLoanData(request.getBookId(), request.getUserId(), borrowDate, dueDate,
                EMPTY_VALUE, STATUS_OPEN, 0.0, LOAN_CREATED_NOTE);
    }

    private void createSmsSyncLoanIfNeeded(BorrowRequest request, String borrowDate, String dueDate) {
        if (CHANNEL_SMS.equals(request.getChannel())) {
            LegacyDatabase.addLoanData(request.getBookId(), request.getUserId(), borrowDate, dueDate,
                    EMPTY_VALUE, STATUS_OPEN, 0.0, LOAN_CREATED_SYNC_NOTE);
        }
    }

    private void decreaseAvailableCopies(Map<String, Object> book) {
        int availableCopies = ((Integer) book.get(FIELD_AVAILABLE_COPIES)).intValue();
        book.put(FIELD_AVAILABLE_COPIES, availableCopies - 1);
    }

    private void notifyLoanCreated(BorrowRequest request, String borrowDate, String dueDate) {
        notificationService.notifyLoanCreated(request.getUserId(), request.getBookId(), borrowDate, dueDate,
                request.getChannel(), LOAN_NOTIFICATION_TEMPLATE, LOAN_NOTIFICATION_MANAGER);
    }

    private void logLoanPolicy(BorrowRequest request) {
        if (request.getPolicyCode() == POLICY_CODE_SPECIAL_7) {
            LegacyDatabase.addLog("loan-policy-7-" + request.getProcess());
        } else if (request.getPolicyCode() == POLICY_CODE_SPECIAL_8) {
            LegacyDatabase.addLog("loan-policy-8-" + request.getProcess());
        } else {
            LegacyDatabase.addLog("loan-policy-default-" + request.getProcess());
        }
    }

    public void returnBook(int loanId, String returnedDate, String channel, int forceFlag, String process,
            String handler) {
        Map<String, Object> loan = LegacyDatabase.getLoanById(loanId);

        if (loan == null) {
            LegacyDatabase.addLog("loan-not-found-ignored-" + loanId);
            return;
        }

        if (STATUS_OPEN.equals(String.valueOf(loan.get(FIELD_STATUS)))) {
            int userId = ((Integer) loan.get(FIELD_USER_ID)).intValue();
            int bookId = ((Integer) loan.get(FIELD_BOOK_ID)).intValue();
            Map<String, Object> user = LegacyDatabase.getUserById(userId);
            Map<String, Object> book = LegacyDatabase.getBookById(bookId);

            if (user != null && book != null) {
                if (DataUtil.isBlank(returnedDate)) {
                    returnedDate = DataUtil.nowDate();
                }
                loan.put(FIELD_RETURNED_DATE, returnedDate);
                loan.put(FIELD_STATUS, STATUS_CLOSED);

                double fine = calculateFineLegacy(String.valueOf(loan.get(FIELD_DUE_DATE)), returnedDate, forceFlag, process,
                        handler, userId, bookId);
                loan.put(FIELD_FINE, fine);

                int av = ((Integer) book.get(FIELD_AVAILABLE_COPIES)).intValue();
                int total = ((Integer) book.get(FIELD_TOTAL_COPIES)).intValue();
                av = av + 1;
                if (av > total) {
                    av = total;
                }
                book.put(FIELD_AVAILABLE_COPIES, av);

                if (fine > 0) {
                    double debt = ((Double) user.get(FIELD_DEBT)).doubleValue();
                    debt = debt - fine;
                    user.put(FIELD_DEBT, debt);
                }

                notificationService.notifyReturn(userId, bookId, STATUS_CLOSED, fine, channel);
                LegacyDatabase.addLog("loan-return-ok-" + loanId + "-" + process + "-" + handler);
            } else {
                throw new RuntimeException("user/book missing for return");
            }
        } else {
            throw new RuntimeException("loan already closed");
        }
    }

    public double calculateFineLegacy(String dueDate, String returnedDate, int forceFlag, String process, String helper,
            int userId, int bookId) {
        double fine = 0.0;

        if (dueDate != null && returnedDate != null) {
            if (returnedDate.compareTo(dueDate) > 0) {
                int days = 1;

                if (forceFlag == 1) {
                    fine = 0.0;
                } else {
                    if (forceFlag == 2) {
                        fine = days * 1.0;
                    } else {
                        fine = days * LegacyDatabase.GLOBAL_FINE_PER_DAY;
                    }
                }
            }
        }

        if (fine > 50) {
            notificationService.sendDebtAlert(userId, fine, 2, process);
        } else if (fine > 100) {
            notificationService.sendDebtAlert(userId, fine, 3, process);
        }

        if (bookId % 2 == 0) {
            LegacyDatabase.addLog("fine-book-even-" + helper);
        } else {
            LegacyDatabase.addLog("fine-book-odd-" + helper);
        }

        return fine;
    }

    public void listOpenLoans() {
        logger.info("ID | USER | BOOK | BORROW | DUE | STATUS | FINE");
        List<Map<String, Object>> list = LegacyDatabase.getLoans();
        for (Map<String, Object> item : list) {
            if (STATUS_OPEN.equals(String.valueOf(item.get(FIELD_STATUS)))) {
                logger.info("{} | {} | {} | {} | {} | {} | {}", item.get(FIELD_ID), item.get(FIELD_USER_ID),
                        item.get(FIELD_BOOK_ID), item.get(FIELD_BORROW_DATE), item.get(FIELD_DUE_DATE),
                        item.get(FIELD_STATUS), item.get(FIELD_FINE));
            }
        }
    }

    public void listAllLoans() {
        logger.info("ID | USER | BOOK | BORROW | DUE | RETURNED | STATUS | FINE");
        List<Map<String, Object>> list = LegacyDatabase.getLoans();
        for (Map<String, Object> item : list) {
            logger.info("{} | {} | {} | {} | {} | {} | {} | {}", item.get(FIELD_ID), item.get(FIELD_USER_ID),
                    item.get(FIELD_BOOK_ID), item.get(FIELD_BORROW_DATE), item.get(FIELD_DUE_DATE),
                    item.get(FIELD_RETURNED_DATE), item.get(FIELD_STATUS), item.get(FIELD_FINE));
        }
    }

    public void borrowFromConsole() {
        int userId = DataUtil.askInt("User ID: ", -1);
        int bookId = DataUtil.askInt("Book ID: ", -1);
        String borrowDate = DataUtil.ask("Borrow date (yyyy-MM-dd): ", DataUtil.nowDate());
        String dueDate = DataUtil.ask("Due date (yyyy-MM-dd): ", DataUtil.datePlusDaysApprox(borrowDate, 14));
        String channel = DataUtil.ask("Channel (email/sms): ", CHANNEL_EMAIL);
        int maxDays = DataUtil.askInt("Max days: ", 14);
        int policyCode = DataUtil.askInt("Policy code: ", 0);

        BorrowRequest request = BorrowRequest.builder()
                .userId(userId)
                .bookId(bookId)
                .borrowDate(borrowDate)
                .dueDate(dueDate)
                .channel(channel)
                .maxDays(maxDays)
                .process(PROCESS_CLI)
                .policyCode(policyCode)
                .build();
        int loanId = borrowBook(request);
        logger.info("Loan created with id {}", loanId);
    }

    public void returnFromConsole() {
        int loanId = DataUtil.askInt("Loan ID: ", -1);
        String returnedDate = DataUtil.ask("Returned date (yyyy-MM-dd): ", DataUtil.nowDate());
        String channel = DataUtil.ask("Channel (email/sms): ", CHANNEL_EMAIL);
        int forceFlag = DataUtil.askInt("Force flag (0/1/2): ", 0);

        returnBook(loanId, returnedDate, channel, forceFlag, PROCESS_CLI, RETURN_HANDLER);
        logger.info("Return processed");
    }
}
