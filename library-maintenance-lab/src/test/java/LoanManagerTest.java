import static org.junit.Assert.assertEquals;

import org.junit.Before;
import org.junit.Test;

public class LoanManagerTest {

    @Before
    public void resetLegacyDatabase() {
        LegacyDatabase.getBooks().clear();
        LegacyDatabase.getUsers().clear();
        LegacyDatabase.getLoans().clear();
        LegacyDatabase.getLogs().clear();
        LegacyDatabase.BOOK_SEQ = 1;
        LegacyDatabase.USER_SEQ = 1;
        LegacyDatabase.LOAN_SEQ = 1;
        LegacyDatabase.seedInitialData();
    }

    @Test
    public void deveCalcularMultaPadraoQuandoHouverAtraso() {
        LoanManager loanManager = new LoanManager();

        double fine = loanManager.calculateFineLegacy("2026-05-01", "2026-05-02", 0, "teste", "helper", 1, 2);

        assertEquals(2.0, fine, 0.0001);
    }

    @Test
    public void deveRetornarZeroQuandoNaoHouverAtraso() {
        LoanManager loanManager = new LoanManager();

        double fine = loanManager.calculateFineLegacy("2026-05-10", "2026-05-10", 0, "teste", "helper", 1, 2);

        assertEquals(0.0, fine, 0.0001);
    }

    @Test
    public void deveEmprestarLivroUsandoBorrowRequest() {
        LoanManager loanManager = new LoanManager();
        BorrowRequest request = BorrowRequest.builder()
                .userId(1)
                .bookId(1)
                .borrowDate("2026-05-01")
                .dueDate("2026-05-15")
                .channel("email")
                .maxDays(14)
                .process("teste")
                .policyCode(0)
                .build();

        int loanId = loanManager.borrowBook(request);

        assertEquals(1, loanId);
        assertEquals(1, LegacyDatabase.getLoans().size());
        assertEquals(2, LegacyDatabase.getBookById(1).get("availableCopies"));
    }
}
