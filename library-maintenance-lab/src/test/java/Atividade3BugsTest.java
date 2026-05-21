import org.junit.Before;
import org.junit.Test;

public class Atividade3BugsTest {

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

    @Test(expected = IllegalArgumentException.class)
    public void deveFalharRapidoQuandoDevolverEmprestimoInexistente() {
        LoanManager loanManager = new LoanManager();

        loanManager.returnBook(9999, "2026-05-13", "email", 0, "teste", "handler");
    }

    @Test(expected = IllegalArgumentException.class)
    public void deveRejeitarCadastroQuandoCopiasDisponiveisForemMaioresQueTotal() {
        BookManager bookManager = new BookManager();

        bookManager.registerBook(
                "Clean Code",
                "Robert Martin",
                2008,
                "CS",
                2,
                10,
                "A1",
                "ISBN-123"
        );
    }

    @Test(expected = IllegalArgumentException.class)
    public void deveRejeitarCadastroQuandoAnoForInvalido() {
        BookManager bookManager = new BookManager();

        bookManager.registerBook(
                "Test Book",
                "Test Author",
                -500,
                "CS",
                1,
                1,
                "A2",
                "TEST"
        );
    }
}