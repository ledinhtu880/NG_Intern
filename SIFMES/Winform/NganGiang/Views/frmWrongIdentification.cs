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
using static System.Windows.Forms.VisualStyles.VisualStyleElement.StartPanel;

namespace NganGiang.Views
{
    public partial class frmWrongIdentification : Form
    {
        private PythonController pyController;
        private List<string> imagePath = new List<string>();

        public frmWrongIdentification()
        {
            InitializeComponent();
            pyController = new PythonController();
            imagePath = pyController.DisplayDataForSelectedDate(DateTime.Today, dgvReport);
        }
        private void dtpkDate_ValueChanged(object sender, EventArgs e)
        {
            DateTime selectedDate = dtpkDate.Value;

            imagePath = pyController.DisplayDataForSelectedDate(selectedDate, dgvReport);
        }

        private void btnShowAll_Click(object sender, EventArgs e)
        {
            dtpkDate.Value = DateTime.Today;
            imagePath = pyController.DisplayDataForAll(dgvReport);
        }
        private void btnDeleteAll_Click(object sender, EventArgs e)
        {
            if (dgvReport.Rows.Count > 0)
            {
                if (MessageBox.Show("Bạn có muốn xóa tất cả hình ảnh?", "Cảnh báo", MessageBoxButtons.YesNo, MessageBoxIcon.Exclamation) == DialogResult.Yes)
                {
                    pyController.DeleteAllWrongIdentification(dgvReport);
                    MessageBox.Show("Xóa thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
            }
            else
            {
                MessageBox.Show("Không có dữ liệu", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void dgvReport_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.ColumnIndex == dgvReport.Columns["btnTrain"].Index && e.RowIndex >= 0)
            {
                int stt = Convert.ToInt32(dgvReport.Rows[e.RowIndex].Cells["STT"].Value);
                string correctName = dgvReport.Rows[e.RowIndex].Cells["CorrectIdentificationName"].Value.ToString();

                if (!string.IsNullOrEmpty(correctName))
                {
                    string filePath = imagePath[stt - 1];
                    try
                    {
                        DataGridViewRow row = dgvReport.Rows[stt - 1];

                        string fileName = Path.GetFileName(filePath);

                        if (row.Cells["ImageIdentification"].Value is Image currentImage)
                        {
                            currentImage.Dispose(); // Giải phóng ảnh hiện tại
                        }
                        Image newImage = Image.FromFile("./Processing.jpg");
                        row.Cells["ImageIdentification"].Value = newImage;

                        string appDirectory = AppDomain.CurrentDomain.BaseDirectory;
                        string destinationPath = Path.Combine(appDirectory, "Resources", "Datasets", fileName);

                        try
                        {
                            File.Move(filePath, destinationPath);
                            pyController.RunEncodeImagesInDataset(correctName);
                            pyController.StopRecognition();
                        }
                        catch (IOException ex)
                        {
                            MessageBox.Show($"Có lỗi IO khi di chuyển tệp {filePath} đến {destinationPath}: {ex.Message}");
                        }
                        newImage.Dispose();

                    }
                    catch (IOException ex)
                    {
                        MessageBox.Show($"Có lỗi IO khi thực hiện thao tác trên tệp {filePath}: {ex.Message}");
                    }
                    catch (Exception ex)
                    {
                        MessageBox.Show($"Đã xảy ra một ngoại lệ không xác định: {ex.Message}");
                    }

                    imagePath = dtpkDate.Value.Date != DateTime.Today
                        ? pyController.DisplayDataForSelectedDate(dtpkDate.Value.Date, dgvReport)
                        : pyController.DisplayDataForAll(dgvReport);
                    MessageBox.Show("Huấn luyện thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                else
                {
                    MessageBox.Show("Vui lòng nhập tên trước khi huấn luyện!");
                }
            }
            else if (e.ColumnIndex == dgvReport.Columns["btnDelete"].Index && e.RowIndex >= 0)
            {
                int stt = Convert.ToInt32(dgvReport.Rows[e.RowIndex].Cells["STT"].Value);

                string filePath = imagePath[stt - 1];

                if (MessageBox.Show("Bạn có muốn xóa hình ảnh này?", "Cảnh báo", MessageBoxButtons.YesNo, MessageBoxIcon.Exclamation) == DialogResult.Yes)
                {
                    try
                    {
                        DataGridViewRow row = dgvReport.Rows[stt - 1];

                        string fileName = Path.GetFileName(filePath);
                        if (row.Cells["ImageIdentification"].Value is Image currentImage)
                        {
                            currentImage.Dispose(); // Giải phóng ảnh hiện tại
                        }
                        Image newImage = Image.FromFile("./Processing.jpg");
                        row.Cells["ImageIdentification"].Value = newImage;

                        try
                        {
                            File.Delete(filePath);
                        }
                        catch (IOException ex)
                        {
                            MessageBox.Show($"Có lỗi IO khi xóa tệp {filePath}: {ex.Message}");
                        }
                        newImage.Dispose();

                    }
                    catch (IOException ex)
                    {
                        MessageBox.Show($"Có lỗi IO khi thực hiện thao tác trên tệp {filePath}: {ex.Message}");
                    }
                    catch (Exception ex)
                    {
                        MessageBox.Show($"Đã xảy ra một ngoại lệ không xác định: {ex.Message}");
                    }
                    DateTime selectedDate = dtpkDate.Value.Date;

                    imagePath = (selectedDate != DateTime.Today) ? pyController.DisplayDataForSelectedDate(selectedDate, dgvReport) : pyController.DisplayDataForAll(dgvReport);
                    MessageBox.Show("Xóa thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }

            }
        }
    }
}
