using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
    
namespace NganGiang
{
    internal class DataProvider
    {
        public static string strConnection = @"Data Source=MSI;Initial Catalog=SIFMES;User ID=tus;Password=6451389tu";
        private static DataProvider instance;
        internal static DataProvider Instance
        {
            get
            {
                if (instance == null)
                    instance = new DataProvider();
                return instance;
            }
        }
        public DataTable ExecuteQuery(string query)
        {
            DataTable data = new DataTable();
            using (SqlConnection sqlConnection = new SqlConnection(strConnection))
            {
                sqlConnection.Open();
                SqlCommand cmd = new SqlCommand(query, sqlConnection);
                SqlDataAdapter adapter = new SqlDataAdapter(cmd);
                data.Clear();
                adapter.Fill(data);
                sqlConnection.Close();
            }
            return data;
        }
        public int ExecuteNonQuery(string query)
        {
            int rowsAffected = 0;
            using (SqlConnection sqlConnection = new SqlConnection(strConnection))
            {
                sqlConnection.Open();
                SqlCommand cmd = new SqlCommand(query, sqlConnection);
                rowsAffected = cmd.ExecuteNonQuery();
                sqlConnection.Close();
            }
            return rowsAffected;
        }
        public string GetValue(string query)
        {
            string value = null;
            using (SqlConnection sqlConnection = new SqlConnection(strConnection))
            {
                sqlConnection.Open();
                SqlCommand cmd = new SqlCommand(query, sqlConnection);
                SqlDataReader dataReader = cmd.ExecuteReader();
                while (dataReader.Read())
                {
                    value = dataReader.GetValue(0).ToString();
                }
                sqlConnection.Close();
            }
            return value;
        }
    }
}
