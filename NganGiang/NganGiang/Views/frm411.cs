﻿using NganGiang.Controllers;
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
    public partial class frm411 : Form
    {
        private Station411_Controller controller;
        public frm411()
        {
            InitializeComponent();
            controller = new Station411_Controller();
        }
        private void LoadData()
        {
            DataTable dt = controller.getProcessAt411();
            dgv411.DataSource = dt;
        }
        private void frm411_Load(object sender, EventArgs e)
        {
            this.LoadData();

            foreach (DataGridViewColumn column in dgv411.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

            DataGridViewImageColumn imageColumn = new DataGridViewImageColumn();
            imageColumn.Name = "btnShowInfor";
            imageColumn.HeaderText = "Xem chi tiết";
            dgv411.Columns.Add(imageColumn);
        }
        private void btnProcess_Click(object sender, EventArgs e)
        {
            List<decimal> listIdPackContents = new List<decimal>();
            bool check = false;
            // Kiểm tra xem checkbox đã được check hay chưa
            foreach (DataGridViewRow row in dgv411.Rows)
            {
                if (row != null)
                {
                    DataGridViewCheckBoxCell? cell = row.Cells["IsSelected"] as DataGridViewCheckBoxCell;
                    if (cell != null && cell.Value is bool)
                    {
                        // Nếu checkbox được check thì thêm Id_PackContent vào danh sách
                        if ((Boolean)cell.Value)
                        {
                            listIdPackContents.Add(Convert.ToDecimal(row.Cells["FK_Id_ContentPack"].Value));
                            check = true;
                        }
                    }
                }
            }

            if (check)
            {
                if (MessageBox.Show("Bạn chắc chắn muốn cấp mã NFC các gói trên?", "Xác nhận hành động", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    string message = "";
                    bool result = controller.processAt411(listIdPackContents, out message);
                    if (result)
                    {
                        MessageBox.Show("Cấp mã thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        this.LoadData();
                    }
                    else
                    {
                        MessageBox.Show(message, "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            else
            {
                MessageBox.Show("Vui lòng chọn ít nhất 1 dòng", "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
        }

        private void dgv411_CellMouseEnter(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv411.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                // Thay đổi màu của image thành màu đỏ
                DataGridViewCell cell = dgv411.Rows[e.RowIndex].Cells[e.ColumnIndex];
                if (cell != null)
                {
                    cell.Style.BackColor = Color.FromArgb(132, 145, 165);
                }
            }
        }
        private void dgv411_CellMouseLeave(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv411.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                // Thay đổi màu của image thành màu đỏ
                DataGridViewCell cell = dgv411.Rows[e.RowIndex].Cells[e.ColumnIndex];
                if (cell != null)
                {
                    cell.Style.BackColor = Color.White;
                }
            }
        }
        private void dgv410_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (dgv411.Columns[e.ColumnIndex].Name.Equals("btnShowInfor"))
            {
                string imagePath = Path.Combine("..", "..", "..", "Resources", "eye-solid.png");
                if (File.Exists(imagePath))
                {
                    Image image = Image.FromFile(imagePath);
                    e.Value = image;
                }
            }
        }
        private void dgv411_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgv411.Columns["btnShowInfor"].Index && e.RowIndex >= 0)
            {
                decimal Id_SimpleContent = Convert.ToDecimal(dgv411.Rows[e.RowIndex].Cells["FK_Id_ContentPack"].Value);
                DataTable displayInfoOrder = controller.getInforSimpleContentByContentPack(Id_SimpleContent);
                detailContentSimple dio = new detailContentSimple(displayInfoOrder, Id_SimpleContent);
                dio.ShowDialog();
            }
        }

    }
}