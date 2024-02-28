using NganGiang.Controllers;
using NganGiang.Libs;
using NganGiang.Models;
using NganGiang.Views;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace NganGiang
{
    public partial class frmLogin : Form
    {
        private AuthenticatorController authController;

        public frmLogin()
        {
            InitializeComponent();
            authController = new AuthenticatorController();

        }
        private void btnLogIn_Click(object sender, EventArgs e)
        {
            string username = txtUsername.Text;
            string password = txtPassword.Text;
            if (String.IsNullOrEmpty(username))
            {
                MessageBox.Show("Bạn phải điền tên đăng nhập", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else if (String.IsNullOrEmpty(password))
            {
                MessageBox.Show("Bạn phải điền mật khẩu", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {
                if (authController.CheckLogin(username, password))
                {
                    int Id_User = -1;
                    string name = String.Empty;

                    string query = $"select Id_User, Name from [User] where username = '{username}'";
                    SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
                    if (reader.Read())
                    {
                        Id_User = reader.GetInt16(0);
                        name = reader.GetString(1);
                    }

                    txtUsername.Clear();
                    txtPassword.Clear();
                    frmMain newFrm = new frmMain(Id_User, name, username);
                    newFrm.LogOut += NewFrm_LogOut;
                    this.Hide();
                    newFrm.Show();
                }
                else
                {
                    MessageBox.Show("Sai tên tài khoản hoặc mật khẩu", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void NewFrm_LogOut(object sender, EventArgs e)
        {
            ((frmMain)sender).isLogOut = false;
            ((frmMain)sender).Close();
            this.Show();
        }

        private void btnRedirect_Click(object sender, EventArgs e)
        {
            frmRecognize newFormRecognize = new frmRecognize();
            newFormRecognize.FormClosed += (s, args) => this.Show();
            this.Hide(); // Ẩn form chính
            newFormRecognize.ShowDialog();
            this.MinimizeBox = true;
        }
    }
}
