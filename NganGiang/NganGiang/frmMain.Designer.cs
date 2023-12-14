namespace NganGiang
{
    partial class frmMain
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmMain));
            panelHeader = new Panel();
            btnLogOut = new Button();
            lbHeader = new Label();
            pictureBox1 = new PictureBox();
            panelFooter = new Panel();
            label1 = new Label();
            panelMain = new Panel();
            panelSelect = new Panel();
            btnProcess = new Button();
            cbStation = new ComboBox();
            labelSelect = new Label();
            panelHeader.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)pictureBox1).BeginInit();
            panelFooter.SuspendLayout();
            panelMain.SuspendLayout();
            panelSelect.SuspendLayout();
            SuspendLayout();
            // 
            // panelHeader
            // 
            panelHeader.BackColor = SystemColors.ControlLightLight;
            panelHeader.Controls.Add(btnLogOut);
            panelHeader.Controls.Add(lbHeader);
            panelHeader.Controls.Add(pictureBox1);
            panelHeader.Dock = DockStyle.Top;
            panelHeader.Location = new Point(0, 0);
            panelHeader.Name = "panelHeader";
            panelHeader.Size = new Size(584, 125);
            panelHeader.TabIndex = 0;
            // 
            // btnLogOut
            // 
            btnLogOut.AutoSize = true;
            btnLogOut.BackColor = Color.Transparent;
            btnLogOut.FlatAppearance.BorderSize = 0;
            btnLogOut.FlatStyle = FlatStyle.Flat;
            btnLogOut.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            btnLogOut.ForeColor = SystemColors.ControlText;
            btnLogOut.Location = new Point(206, 39);
            btnLogOut.Name = "btnLogOut";
            btnLogOut.Size = new Size(124, 40);
            btnLogOut.TabIndex = 5;
            btnLogOut.Text = "Đăng xuất";
            btnLogOut.UseVisualStyleBackColor = false;
            btnLogOut.Click += btnLogOut_Click;
            // 
            // lbHeader
            // 
            lbHeader.AutoSize = true;
            lbHeader.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            lbHeader.Location = new Point(332, 47);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(100, 28);
            lbHeader.TabIndex = 4;
            lbHeader.Text = "Xin chào ";
            // 
            // pictureBox1
            // 
            pictureBox1.Image = Properties.Resources.logo;
            pictureBox1.Location = new Point(32, 36);
            pictureBox1.Margin = new Padding(4);
            pictureBox1.Name = "pictureBox1";
            pictureBox1.Size = new Size(150, 50);
            pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
            pictureBox1.TabIndex = 1;
            pictureBox1.TabStop = false;
            // 
            // panelFooter
            // 
            panelFooter.BackColor = SystemColors.ControlLightLight;
            panelFooter.Controls.Add(label1);
            panelFooter.Dock = DockStyle.Bottom;
            panelFooter.Location = new Point(0, 225);
            panelFooter.Margin = new Padding(4);
            panelFooter.Name = "panelFooter";
            panelFooter.Size = new Size(584, 95);
            panelFooter.TabIndex = 2;
            // 
            // label1
            // 
            label1.Anchor = AnchorStyles.None;
            label1.AutoSize = true;
            label1.Location = new Point(99, 33);
            label1.Margin = new Padding(4, 0, 4, 0);
            label1.Name = "label1";
            label1.Size = new Size(372, 28);
            label1.TabIndex = 3;
            label1.Text = "© Copyright 2023 Ngan Giang company.";
            label1.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // panelMain
            // 
            panelMain.BackColor = SystemColors.Window;
            panelMain.Controls.Add(panelSelect);
            panelMain.Dock = DockStyle.Fill;
            panelMain.Location = new Point(0, 125);
            panelMain.Name = "panelMain";
            panelMain.Size = new Size(584, 100);
            panelMain.TabIndex = 3;
            // 
            // panelSelect
            // 
            panelSelect.BackColor = SystemColors.ControlLightLight;
            panelSelect.Controls.Add(btnProcess);
            panelSelect.Controls.Add(cbStation);
            panelSelect.Controls.Add(labelSelect);
            panelSelect.Dock = DockStyle.Fill;
            panelSelect.Location = new Point(0, 0);
            panelSelect.Name = "panelSelect";
            panelSelect.Size = new Size(584, 100);
            panelSelect.TabIndex = 0;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(392, 15);
            btnProcess.Margin = new Padding(4);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(188, 40);
            btnProcess.TabIndex = 6;
            btnProcess.Text = "Điều hướng";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // cbStation
            // 
            cbStation.DropDownStyle = ComboBoxStyle.DropDownList;
            cbStation.FormattingEnabled = true;
            cbStation.Location = new Point(156, 15);
            cbStation.Name = "cbStation";
            cbStation.Size = new Size(205, 36);
            cbStation.TabIndex = 1;
            // 
            // labelSelect
            // 
            labelSelect.AutoSize = true;
            labelSelect.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            labelSelect.Location = new Point(12, 15);
            labelSelect.Name = "labelSelect";
            labelSelect.Size = new Size(111, 28);
            labelSelect.TabIndex = 0;
            labelSelect.Text = "Chọn trạm";
            // 
            // frmMain
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.Window;
            BackgroundImageLayout = ImageLayout.None;
            ClientSize = new Size(584, 320);
            Controls.Add(panelMain);
            Controls.Add(panelFooter);
            Controls.Add(panelHeader);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frmMain";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Trang chủ";
            FormClosed += frmMain_FormClosed;
            Load += frmMain_Load;
            panelHeader.ResumeLayout(false);
            panelHeader.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)pictureBox1).EndInit();
            panelFooter.ResumeLayout(false);
            panelFooter.PerformLayout();
            panelMain.ResumeLayout(false);
            panelSelect.ResumeLayout(false);
            panelSelect.PerformLayout();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelHeader;
        private PictureBox pictureBox1;
        private Panel panelFooter;
        private Label label1;
        private Label labelFooter;
        private Panel panelMain;
        private Panel panelSelect;
        private ComboBox cbStation;
        private Label labelSelect;
        private Button btnProcess;
        private Label lbHeader;
        private Button btnLogOut;
    }
}
