using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace NganGiang.Views
{
    public partial class detailContentSimple : Form
    {
        private DataTable dt;
        private decimal Id_ContentSimple;
        public detailContentSimple(DataTable dt, decimal Id_ContentSimple)
        {
            this.dt = dt;
            this.Id_ContentSimple = Id_ContentSimple;
            InitializeComponent();
        }

        private void btnBack_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void dgv408_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;

        }
        private void detailContentSimple_Load(object sender, EventArgs e)
        {
            lbHeader.Text = "Thông tin chi tiết thùng hàng số " + this.Id_ContentSimple;
            dgv408.DataSource = dt;
        }
    }
}
