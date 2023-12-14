using NganGiang.Libs;
using NganGiang.Models;
using NganGiang.Views;

namespace NganGiang
{
    public partial class frmMain : Form
    {
        private int id;
        private string name;
        public bool isLogOut = true;
        public frmMain(int id, string name)
        {
            this.id = id;
            this.name = name;
            InitializeComponent();
        }

        private void frmMain_Load(object sender, EventArgs e)
        {
            string query = "select Id_Station, Name_Station from Station " +
                "inner join UserStationRole on Id_Station = FK_Id_Station " +
                "inner join[User] on Id_User = FK_Id_User " +
                $"where Id_User = '{this.id}'";
            cbStation.DataSource = DataProvider.Instance.ExecuteQuery(query);
            cbStation.DisplayMember = "Name_Station";
            cbStation.ValueMember = "Id_Station";

            lbHeader.Text = "Xin chào " + this.name;
        }
        public event EventHandler LogOut;
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
    }
}
