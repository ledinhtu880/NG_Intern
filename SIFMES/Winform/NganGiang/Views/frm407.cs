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
    public partial class frm407 : Form
    {
        private Station407_Controller process407Controller { get; set; }
        List<int> list_id_simple = new List<int>();
        public frm407()
        {
            InitializeComponent();
            process407Controller = new Station407_Controller();
        }
        private void Process407_Load(object sender, EventArgs e)
        {
            LoadData();
        }

        private void LoadData()
        {
            if (dgv407.Rows.Count > 0)
            {
                dgv407.Columns.Clear();
                dgv407.DataSource = null;
            }
            process407Controller.DisplayListOrderProcess(dgv407);
        }
        private void dgv407_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
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
        private void dgv407_ColumnAdded(object sender, DataGridViewColumnEventArgs e)
        {
            e.Column.SortMode = DataGridViewColumnSortMode.NotSortable;
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            list_id_simple.Clear();
            foreach (DataGridViewRow row in dgv407.Rows)
            {
                if (Convert.ToBoolean(row.Cells[0].Value) == true)
                {
                    list_id_simple.Add(Convert.ToInt32(row.Cells[3].Value));
                }
            }
            if (list_id_simple.Count > 0)
            {
                bool flag = false;
                DialogResult confirm = MessageBox.Show("Bạn chắc chắn muốn dán nhãn cho các thùng hàng trên?", "Xác nhận hành động", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                if (confirm == DialogResult.OK)
                {
                    foreach (var item in list_id_simple)
                    {
                        if (process407Controller.UpdateData(item))
                        {
                            flag = true;
                        }

                    }
                    if (flag)
                    {
                        MessageBox.Show("Dán nhãn thùng và xuất phiếu giao thành công!", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    }
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
