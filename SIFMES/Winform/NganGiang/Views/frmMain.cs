﻿using NganGiang.Libs;
using NganGiang.Models;
using NganGiang.Views;

namespace NganGiang
{
    public partial class frmMain : Form
    {
        private int id;
        private string name;
        private string username;
        public bool isLogOut = true;
        public event EventHandler LogOut;


        public frmMain(int id, string name, string username)
        {
            this.id = id;
            this.name = name;
            this.username = username;
            InitializeComponent();
        }

        private void frmMain_Load(object sender, EventArgs e)
        {
            string query = "select Id_Station, Name_Station from Station ";
            cbStation.DataSource = DataProvider.Instance.ExecuteQuery(query);
            cbStation.DisplayMember = "Name_Station";
            cbStation.ValueMember = "Id_Station";

            lbHeader.Text = "Xin chào " + this.name;
            if (this.username.ToLower() != "admin")
            {
                btnTrain.Visible = false;
                btnTrain.Enabled = false;
                btnRedirect.Visible = false;
                btnRedirect.Enabled = false;
                btnPermission.Visible = false;
                btnPermission.Enabled = false;
            }
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            string idStation = cbStation.SelectedValue.ToString();
            switch (idStation)
            {
                case "401":
                    frm401 newForm401 = new frm401();
                    newForm401.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm401.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "402":
                    frm402 newForm402 = new frm402();
                    newForm402.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm402.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "403":
                    frm403 newForm403 = new frm403();
                    newForm403.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm403.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "405":
                    frm405 newForm405 = new frm405();
                    newForm405.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm405.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "406":
                    frm406 newForm406 = new frm406();
                    newForm406.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm406.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "407":
                    frm407 newForm407 = new frm407();
                    newForm407.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm407.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "408":
                    frm408 newForm408 = new frm408();
                    newForm408.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm408.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "409":
                    frm409 newForm409 = new frm409();
                    newForm409.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm409.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "410":
                    frm410 newForm410 = new frm410();
                    newForm410.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm410.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "411":
                    frm411 newForm411 = new frm411();
                    newForm411.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm411.ShowDialog();
                    this.MinimizeBox = true;
                    break;
                case "412":
                    frm412 newForm412 = new frm412();
                    newForm412.FormClosed += (s, args) => this.Show();
                    this.Hide(); // Ẩn form chính
                    newForm412.ShowDialog();
                    this.MinimizeBox = true;
                    break;
            }
        }

        private void btnLogOut_Click(object sender, EventArgs e)
        {
            LogOut(this, new EventArgs());
        }

        private void frmMain_FormClosed(object sender, FormClosedEventArgs e)
        {
            if (isLogOut)
            {
                Application.Exit();
            }
        }

        private void btnTrain_Click(object sender, EventArgs e)
        {
            frmTrain newFormTrain = new frmTrain(id, name, username);
            newFormTrain.FormClosed += (s, args) => this.Show();
            this.Hide(); // Ẩn form chính
            newFormTrain.ShowDialog();
            this.MinimizeBox = true;
        }

        private void btnRedirect_Click(object sender, EventArgs e)
        {
            frmWrongIdentification newForm = new frmWrongIdentification();
            newForm.FormClosed += (s, args) => this.Show();
            this.Hide(); // Ẩn form chính
            newForm.ShowDialog();
            this.MinimizeBox = true;
        }

        private void btnPermission_Click(object sender, EventArgs e)
        {
            frmPermission newForm = new frmPermission();
            newForm.FormClosed += (s, args) => this.Show();
            this.Hide(); // Ẩn form chính
            newForm.ShowDialog();
            this.MinimizeBox = true;
        }
    }
}
