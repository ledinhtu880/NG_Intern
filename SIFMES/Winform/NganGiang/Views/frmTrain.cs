using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Xml.Linq;
using System.Diagnostics;
using System.Drawing.Imaging;

using AForge.Video;
using AForge.Video.DirectShow;

using NganGiang.Controllers;

namespace NganGiang.Views
{
    public partial class frmTrain : Form
    {
        private int id;
        private string name;
        private string username;
        private FilterInfoCollection videoDevices;
        private VideoCaptureDevice videoSource;
        private PythonController pyController;
        public frmTrain(int id, string name, string username)
        {
            this.id = id;
            this.name = name;
            this.username = username;
            InitializeComponent();
            pyController = new PythonController();
        }
        private void videoSource_NewFrame(object sender, NewFrameEventArgs eventArgs)
        {
            Bitmap frame = (Bitmap)eventArgs.Frame.Clone();

            frame.RotateFlip(RotateFlipType.RotateNoneFlipX);

            picBoxTrain.SizeMode = PictureBoxSizeMode.Zoom;
            picBoxTrain.Image = frame;
        }
        private void frmTrain_Load(object sender, EventArgs e)
        {
            txtUser.Text = name;
            videoDevices = new FilterInfoCollection(FilterCategory.VideoInputDevice);

            if (videoDevices.Count == 0)
            {
                MessageBox.Show("Không tìm thấy camera.");
                btnCamera.Enabled = false;
                return;
            }
            else
            {
                videoSource = new VideoCaptureDevice(videoDevices[0].MonikerString);
                videoSource.NewFrame += new NewFrameEventHandler(videoSource_NewFrame);

                videoSource.Start();
            }
        }
        private void frmTrain_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (videoSource != null && videoSource.IsRunning)
            {
                videoSource.SignalToStop();
                videoSource.WaitForStop();
            }
        }
        private void btnTake_Click(object sender, EventArgs e)
        {
            Task.Run(() =>
            {
                if (videoSource != null && videoSource.IsRunning)
                {
                    Bitmap frame = null;

                    if (picBoxTrain.InvokeRequired)
                    {
                        picBoxTrain.Invoke(new MethodInvoker(() =>
                        {
                            frame = (Bitmap)picBoxTrain.Image.Clone();
                        }));
                    }
                    else
                    {
                        frame = (Bitmap)picBoxTrain.Image.Clone();
                    }

                    if (frame != null)
                    {
                        string appDirectory = AppDomain.CurrentDomain.BaseDirectory;
                        string datasetDirectory = Path.Combine(appDirectory, "Resources", "Datasets");

                        if (!Directory.Exists(datasetDirectory))
                        {
                            Directory.CreateDirectory(datasetDirectory);
                        }
                        string filePath = Path.Combine(datasetDirectory, $"{username}_{DateTime.Now.Ticks}.png");
                        frame.Save(filePath, ImageFormat.Jpeg);

                        frame.Dispose();
                    }
                    MessageBox.Show("Đã chụp xong");
                }
            });
        }
        private void btnTrain_Click(object sender, EventArgs e)
        {
            pyController.RunEncodeImagesInDataset(username);
            pyController.StopRecognition();

            MessageBox.Show("Huấn luyện thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
        }
    }
}