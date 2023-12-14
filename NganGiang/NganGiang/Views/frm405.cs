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
    public partial class frm405 : Form
    {
        private Station405_Controller processController { get; set; }
        List<int> list_id_simple = new List<int>();
        public frm405()
        {
            InitializeComponent();
            processController = new Station405_Controller();
        }

        private void frm405_Load(object sender, EventArgs e)
        {
            LoadData();
        }
        private void LoadData()
        {
            if (dgv405.Rows.Count > 0)
            {
                dgv405.Columns.Clear();
                dgv405.DataSource = null;
            }
            processController.DisplayListOrderProcess(dgv405);
        }

        private void dgv405_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
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
                DateTime date_start = Convert.ToDateTime(e.Value);
                string formattedDate = date_start.ToString("dd-MM-yyyy");

                e.Value = formattedDate;
                e.FormattingApplied = true;
            }
        }

        private void dgv405_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;
        }

        private void btnProcess_Click(object sender, EventArgs e)
        {
            list_id_simple.Clear();
            foreach (DataGridViewRow row in dgv405.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    list_id_simple.Add(Convert.ToInt32(row.Cells[3].Value));
                }
            }

            if (list_id_simple.Count > 0)
            {
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn muốn cấp nắp thùng cho các thùng hàng trên?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (var item in list_id_simple)
                    {
                        var result = processController.UpdateCoverHatProvided(item);
                        if (!string.IsNullOrEmpty(result))
                        {
                            MessageBox.Show($"{result}", "", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                            return;
                        }

                    }
                    MessageBox.Show("Cấp nắp thùng thành công!", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    LoadData();
                }
            }
            else
            {
                MessageBox.Show("Bạn chưa chọn nội dung sản xuất!", "", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }
    }
}
