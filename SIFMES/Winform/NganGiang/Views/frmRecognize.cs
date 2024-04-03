using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Drawing;
using System.Drawing.Imaging;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;

using AForge.Video;
using AForge.Video.DirectShow;
using NganGiang.Controllers;
using NganGiang.Libs;
using static System.Windows.Forms.VisualStyles.VisualStyleElement.StartPanel;
using System.Data.SqlClient;
using System.Xml.Linq;

namespace NganGiang.Views
{
  public partial class frmRecognize : Form
  {
    private bool isRecognizing = false;
    private bool isCameraRunning = false;
    private PythonController pyController;
    private VideoCaptureDevice videoSource;
    private FilterInfoCollection videoDevices;
    private string tempFolderPath = Path.Combine(Environment.CurrentDirectory, "temp");
    public frmRecognize()
    {
      pyController = new PythonController();
      InitializeComponent();
    }
    private void videoSource_NewFrame(object sender, NewFrameEventArgs eventArgs)
    {
      Bitmap frame = (Bitmap)eventArgs.Frame.Clone();

      frame.RotateFlip(RotateFlipType.RotateNoneFlipX);

      picBoxRecognize.SizeMode = PictureBoxSizeMode.Zoom;
      picBoxRecognize.Image = frame;
    }
    private void frmRecognize_Load(object sender, EventArgs e)
    {
      videoDevices = new FilterInfoCollection(FilterCategory.VideoInputDevice);

      videoSource = new VideoCaptureDevice(videoDevices[0].MonikerString);
      videoSource.NewFrame += new NewFrameEventHandler(videoSource_NewFrame);

      videoSource.Start();
      isCameraRunning = true;

      if (!Directory.Exists(tempFolderPath))
      {
        Directory.CreateDirectory(tempFolderPath);
      }
    }
    private void btnRecognize_Click(object sender, EventArgs e)
    {
      if (isCameraRunning)
      {
        isRecognizing = true;

        Task.Run(() =>
        {
          while (isRecognizing && isCameraRunning)
          {
            string tempFilePath = Path.Combine(tempFolderPath, Guid.NewGuid().ToString() + ".jpg");

            if (videoSource != null && videoSource.IsRunning)
            {
              Bitmap frame = null;

              if (picBoxRecognize.InvokeRequired)
              {
                picBoxRecognize.Invoke(new MethodInvoker(() =>
                        {
                          frame = (Bitmap)picBoxRecognize.Image.Clone();
                        }));
              }
              else
              {
                frame = (Bitmap)picBoxRecognize.Image.Clone();
              }

              if (frame != null)
              {
                frame.Save(tempFilePath, ImageFormat.Jpeg);
                frame.Save(Path.Combine("temp", "original_picture.jpg"), ImageFormat.Jpeg);

                frame.Dispose();
              }
            }

            if (!string.IsNullOrEmpty(tempFilePath))
            {
              Image img = Image.FromFile(tempFilePath);
              string username = pyController.RunRecognition(img);
              if (username.Trim() == "Unknown" || String.IsNullOrEmpty(username.Trim()))
              {
                string ordinImage = Path.Combine("temp", "original_picture.jpg");
                string fileName = DateTime.Now.ToString("yyyy.MM.dd_HH.mm.ss.fff") + ".jpg";
                string saveFolderPath = Path.Combine("WrongIdentification");
                string saveFilePath = Path.Combine(saveFolderPath, fileName);

                File.Copy(ordinImage, saveFilePath);
                MessageBox.Show("Khuôn mặt chưa được nhận dạng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
              }
              else
              {
                username = username.Trim();
                int Id_User = -1;
                string name = String.Empty;

                string query = $"select Id_User, Name from [User] where username = '{username}'";
                SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
                if (reader.Read())
                {
                  Id_User = reader.GetInt16(0);
                  name = reader.GetString(1);
                }

                frmMain newFrm = new frmMain(Id_User, name, username);
                newFrm.LogOut += NewFrm_LogOut;

                if (this.InvokeRequired)
                {
                  this.Invoke(new MethodInvoker(() =>
                          {
                              this.Hide();
                              newFrm.Show();
                            }));
                }
                else
                {
                  this.Hide();
                  newFrm.Show();
                }
                break;
              }
              break;
            }
            Thread.Sleep(1000);
            pyController.StopRecognition();
          }
        });
      }
      else
      {
        MessageBox.Show("Vui lòng mở camera hoặc chọn ảnh trước khi nhận diện.", "Lỗi", MessageBoxButtons.OK, MessageBoxIcon.Error);
        isRecognizing = false;
      }
    }
    private void NewFrm_LogOut(object? sender, EventArgs e)
    {
      ((frmMain)sender).isLogOut = false;
      ((frmMain)sender).Close();
      frmLogin formLogin = new frmLogin();
      formLogin.Show();
    }

    private void frmRecognize_FormClosing(object sender, FormClosingEventArgs e)
    {
      if (videoSource != null && videoSource.IsRunning)
      {
        videoSource.SignalToStop();
        videoSource.WaitForStop();
      }
    }
  }
}
