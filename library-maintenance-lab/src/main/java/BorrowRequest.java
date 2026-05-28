public class BorrowRequest {

    private final int userId;
    private final int bookId;
    private final String borrowDate;
    private final String dueDate;
    private final String channel;
    private final int maxDays;
    private final String process;
    private final int policyCode;

    private BorrowRequest(Builder builder) {
        this.userId = builder.userId;
        this.bookId = builder.bookId;
        this.borrowDate = builder.borrowDate;
        this.dueDate = builder.dueDate;
        this.channel = builder.channel;
        this.maxDays = builder.maxDays;
        this.process = builder.process;
        this.policyCode = builder.policyCode;
    }

    public static Builder builder() {
        return new Builder();
    }

    public int getUserId() {
        return userId;
    }

    public int getBookId() {
        return bookId;
    }

    public String getBorrowDate() {
        return borrowDate;
    }

    public String getDueDate() {
        return dueDate;
    }

    public String getChannel() {
        return channel;
    }

    public int getMaxDays() {
        return maxDays;
    }

    public String getProcess() {
        return process;
    }

    public int getPolicyCode() {
        return policyCode;
    }

    public static class Builder {

        private int userId;
        private int bookId;
        private String borrowDate;
        private String dueDate;
        private String channel;
        private int maxDays;
        private String process;
        private int policyCode;

        public Builder userId(int userId) {
            this.userId = userId;
            return this;
        }

        public Builder bookId(int bookId) {
            this.bookId = bookId;
            return this;
        }

        public Builder borrowDate(String borrowDate) {
            this.borrowDate = borrowDate;
            return this;
        }

        public Builder dueDate(String dueDate) {
            this.dueDate = dueDate;
            return this;
        }

        public Builder channel(String channel) {
            this.channel = channel;
            return this;
        }

        public Builder maxDays(int maxDays) {
            this.maxDays = maxDays;
            return this;
        }

        public Builder process(String process) {
            this.process = process;
            return this;
        }

        public Builder policyCode(int policyCode) {
            this.policyCode = policyCode;
            return this;
        }

        public BorrowRequest build() {
            return new BorrowRequest(this);
        }
    }
}
