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
    public partial class frm402 : Form
    {
        private Controllers.Station402_Controller processContentSimpleController;
        public frm402()
        {
            InitializeComponent();
            processContentSimpleController = new Controllers.Station402_Controller();
        }

        private void frm402_Load(object sender, EventArgs e)
        {
            LoadData();

        }
        private void LoadData()
        {
            DataTable dt = processContentSimpleController.getProcessContentSimple();
            dgv402.DataSource = dt;
        }

        private void btnProcess_Click(object sender, EventArgs e)
        {
            List<string> Id_SimpleContents = new List<string>();
            bool check = false;
            // Kiểm tra xem checkbox đã được check hay chưa
            foreach (DataGridViewRow row in dgv402.Rows)
            {
                if (row != null)
                {
                    DataGridViewCheckBoxCell? cell = row.Cells["IsSelected"] as DataGridViewCheckBoxCell;
                    if (cell != null && cell.Value is bool)
                    {
                        // Nếu checkbox được check thì thêm Id_SimpleContent vào danh sách
                        if ((Boolean)cell.Value)
                        {
                            Id_SimpleContents.Add(row.Cells["Mã thùng hàng"].Value.ToString());
                            check = true;
                        }
                    }
                }
            }
            if (check)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn rót nguyên liệu rắn vào thùng hàng?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    processContentSimpleController.UpdateRawMaterialDispenser(Id_SimpleContents);
                    LoadData();
                }
            }
            else
            {
                MessageBox.Show("Vui lòng chọn ít nhất 1 dòng", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
        }

        private void dgv402_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.ColumnIndex == 9) // Kiểm tra cột "Ngày bắt đầu"
            {
                if (e.Value != null && e.Value != DBNull.Value)
                {
                    DateTime date;
                    if (DateTime.TryParse(e.Value.ToString(), out date))
                    {
                        e.Value = date.ToString("dd/MM/yyyy");
                        e.FormattingApplied = true; // Đánh dấu đã áp dụng định dạng
                    }
                }
            }
        }
    }
}
