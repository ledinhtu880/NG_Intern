using NganGiang.Services;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Station403
{
    public partial class Form1 : Form
    {
        PLCService plcService { get; set; }
        bool isPLCReady = false;
        public Form1()
        {
            InitializeComponent(); 
            plcService = new PLCService();
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            if (!isPLCReady)
            {
                isPLCReady = true;
                timer1.Enabled = false;
                lbStatus.Text += "Connected";
                MessageBox.Show("PLC đã sẵn sàng", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
        }
    }
}
