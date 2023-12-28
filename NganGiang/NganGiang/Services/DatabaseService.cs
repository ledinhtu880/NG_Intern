using System.Data;
using System.Data.SqlClient;

namespace NganGiang.Services
{
    public class DatabaseService
    {
        const string CONN = @"Data Source=DESKTOP-KS6PGS1;Initial Catalog=SIFMES;User ID=sa;Password=123";

        public SqlCommand SqlCommandText
        {
            get
            {
                SqlCommand _SqlCommandText = new SqlCommand();
                SqlConnection sqlConnection = new SqlConnection(CONN);
                _SqlCommandText.Connection = sqlConnection;
                _SqlCommandText.CommandType = System.Data.CommandType.Text;

                return _SqlCommandText;
            }
        }

        public DataTable ExecuteCommand(SqlCommand SqlCommandText)
        {
            SqlDataAdapter da = new SqlDataAdapter(SqlCommandText);
            DataTable dt = new DataTable();
            da.Fill(dt);

            return dt;
        }
    }
}
