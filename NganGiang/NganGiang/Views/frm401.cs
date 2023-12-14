using NganGiang.Controllers;
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
    public partial class frm401 : Form
    {
        Station401_Controller processController { get; set; }
        List<int> chk = new List<int>();
        public frm401()
        {
            InitializeComponent();
            processController = new Station401_Controller();
        }
        private void LoadData()
        {
            if (dgv401.Rows.Count > 0)
            {
                dgv401.Columns.Clear();
                dgv401.DataSource = null;
            }
            processController.DisplayListOrderProcess(dgv401);
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            chk.Clear();
            foreach (DataGridViewRow row in dgv401.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    chk.Add(Convert.ToInt32(row.Cells[3].Value));
                }
            }


            if (chk.Count > 0)
            {
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn muốn cấp thùng chứa và đế dán mã RFID cho các thùng hàng trên?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (var item in chk)
                    {
                        var result = processController.UpdateProcessAndSimple(item);
                        if (!string.IsNullOrEmpty(result))
                        {
                            MessageBox.Show($"{result}", "", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                            return;
                        }

                    }
                    MessageBox.Show("Cấp thùng chứa và đế dán mã RFID thành công!", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    LoadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void dgv401_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.ColumnIndex == 2 && e.Value is bool)
            {
                bool cellValue = Convert.ToBoolean(e.Value);
                string stringValue = cellValue ? "Gói hàng" : "Thùng hàng";

                e.Value = stringValue;
                e.FormattingApplied = true;
            }

            if (e.ColumnIndex == 9)
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

        private void frm401_Load(object sender, EventArgs e)
        {
            LoadData();
        }
    }
}
