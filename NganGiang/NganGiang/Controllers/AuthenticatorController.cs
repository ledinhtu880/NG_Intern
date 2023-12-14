using NganGiang.Libs;
using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using BCrypt.Net;
using static System.Windows.Forms.VisualStyles.VisualStyleElement.StartPanel;

namespace NganGiang.Controllers
{
    internal class AuthenticatorController
    {
        public string GetHashedPassword(string username)
        {
            string query = "SELECT Password FROM [User] WHERE UserName = @username";
            SqlParameter[] parameters =
            {
            new SqlParameter("@username", username)
        };
            DataTable dt = DataProvider.Instance.ExecuteQuery(query, parameters);
            if (dt.Rows.Count > 0)
            {
                return dt.Rows[0]["Password"].ToString();
            }
            return null;
        }
        public bool CheckLogin(string username, string password)
        {
            string hashedPassword = GetHashedPassword(username);
            // Chỉnh sửa ở đây: Sử dụng Verify của BCrypt.Net với cả hai định dạng "$2a$" và "$2y$"
            bool isPasswordCorrect = BCrypt.Net.BCrypt.Verify(password, hashedPassword);
            if (isPasswordCorrect)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
