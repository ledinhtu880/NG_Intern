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
            panelFooter = new Panel();
            label1 = new Label();
            panelMain = new Panel();
            panelSelect = new Panel();
            btnProcess = new Button();
            cbStation = new ComboBox();
            labelSelect = new Label();
            pictureBox1 = new PictureBox();
            lbHeader = new Label();
            btnLogOut = new Button();
            btnTrain = new Button();
            btnRedirect = new Button();
            btnPermission = new Button();
            panelHeader = new Panel();
            panelFooter.SuspendLayout();
            panelMain.SuspendLayout();
            panelSelect.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)pictureBox1).BeginInit();
            panelHeader.SuspendLayout();
            SuspendLayout();
            // 
            // panelFooter
            // 
            panelFooter.BackColor = SystemColors.ControlLightLight;
            panelFooter.Controls.Add(label1);
            panelFooter.Dock = DockStyle.Bottom;
            panelFooter.Location = new Point(0, 240);
            panelFooter.Margin = new Padding(4);
            panelFooter.Name = "panelFooter";
            panelFooter.Size = new Size(687, 49);
            panelFooter.TabIndex = 2;
            // 
            // label1
            // 
            label1.Anchor = AnchorStyles.None;
            label1.AutoSize = true;
            label1.Location = new Point(149, 10);
            label1.Margin = new Padding(4, 0, 4, 0);
            label1.Name = "label1";
            label1.Size = new Size(295, 21);
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
            panelMain.Size = new Size(687, 115);
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
            panelSelect.Size = new Size(687, 115);
            panelSelect.TabIndex = 0;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(515, 41);
            btnProcess.Margin = new Padding(4);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(141, 40);
            btnProcess.TabIndex = 6;
            btnProcess.Text = "Điều hướng";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // cbStation
            // 
            cbStation.DropDownStyle = ComboBoxStyle.DropDownList;
            cbStation.FormattingEnabled = true;
            cbStation.Location = new Point(149, 47);
            cbStation.Name = "cbStation";
            cbStation.Size = new Size(350, 29);
            cbStation.TabIndex = 1;
            // 
            // labelSelect
            // 
            labelSelect.AutoSize = true;
            labelSelect.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            labelSelect.Location = new Point(32, 46);
            labelSelect.Name = "labelSelect";
            labelSelect.Size = new Size(90, 21);
            labelSelect.TabIndex = 0;
            labelSelect.Text = "Chọn trạm";
            // 
            // pictureBox1
            // 
            pictureBox1.ErrorImage = Properties.Resources.logo;
            pictureBox1.Image = Properties.Resources.logo;
            pictureBox1.InitialImage = null;
            pictureBox1.Location = new Point(32, 31);
            pictureBox1.Margin = new Padding(4);
            pictureBox1.Name = "pictureBox1";
            pictureBox1.Size = new Size(150, 50);
            pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
            pictureBox1.TabIndex = 1;
            pictureBox1.TabStop = false;
            // 
            // lbHeader
            // 
            lbHeader.AutoSize = true;
            lbHeader.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            lbHeader.Location = new Point(473, 25);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(80, 21);
            lbHeader.TabIndex = 4;
            lbHeader.Text = "Xin chào ";
            // 
            // btnLogOut
            // 
            btnLogOut.AutoSize = true;
            btnLogOut.BackColor = Color.Transparent;
            btnLogOut.FlatAppearance.BorderSize = 0;
            btnLogOut.FlatStyle = FlatStyle.Flat;
            btnLogOut.Font = new Font("Segoe UI", 12F, FontStyle.Bold | FontStyle.Underline);
            btnLogOut.ForeColor = SystemColors.Highlight;
            btnLogOut.Location = new Point(193, 19);
            btnLogOut.Name = "btnLogOut";
            btnLogOut.Size = new Size(120, 38);
            btnLogOut.TabIndex = 5;
            btnLogOut.Text = "Đăng xuất";
            btnLogOut.UseVisualStyleBackColor = false;
            btnLogOut.Click += btnLogOut_Click;
            // 
            // btnTrain
            // 
            btnTrain.BackColor = Color.Transparent;
            btnTrain.FlatAppearance.BorderSize = 0;
            btnTrain.FlatStyle = FlatStyle.Flat;
            btnTrain.Font = new Font("Segoe UI", 12F, FontStyle.Bold | FontStyle.Underline);
            btnTrain.ForeColor = SystemColors.Highlight;
            btnTrain.Location = new Point(190, 64);
            btnTrain.Name = "btnTrain";
            btnTrain.Size = new Size(135, 40);
            btnTrain.TabIndex = 9;
            btnTrain.Text = "Huấn luyện";
            btnTrain.UseVisualStyleBackColor = false;
            btnTrain.Click += btnTrain_Click;
            // 
            // btnRedirect
            // 
            btnRedirect.AutoSize = true;
            btnRedirect.BackColor = Color.Transparent;
            btnRedirect.FlatAppearance.BorderSize = 0;
            btnRedirect.FlatStyle = FlatStyle.Flat;
            btnRedirect.Font = new Font("Segoe UI", 12F, FontStyle.Bold | FontStyle.Underline);
            btnRedirect.ForeColor = SystemColors.Highlight;
            btnRedirect.Location = new Point(331, 64);
            btnRedirect.Name = "btnRedirect";
            btnRedirect.Size = new Size(275, 40);
            btnRedirect.TabIndex = 10;
            btnRedirect.Text = "Khuôn mặt chưa được nhận dạng";
            btnRedirect.UseVisualStyleBackColor = false;
            btnRedirect.Click += btnRedirect_Click;
            // 
            // btnPermission
            // 
            btnPermission.BackColor = Color.Transparent;
            btnPermission.FlatAppearance.BorderSize = 0;
            btnPermission.FlatStyle = FlatStyle.Flat;
            btnPermission.Font = new Font("Segoe UI", 12F, FontStyle.Bold | FontStyle.Underline);
            btnPermission.ForeColor = SystemColors.Highlight;
            btnPermission.Location = new Point(318, 18);
            btnPermission.Name = "btnPermission";
            btnPermission.Size = new Size(135, 40);
            btnPermission.TabIndex = 11;
            btnPermission.Text = "Phân quyền";
            btnPermission.UseVisualStyleBackColor = false;
            btnPermission.Click += btnPermission_Click;
            // 
            // panelHeader
            // 
            panelHeader.BackColor = SystemColors.ControlLightLight;
            panelHeader.Controls.Add(btnPermission);
            panelHeader.Controls.Add(btnRedirect);
            panelHeader.Controls.Add(btnTrain);
            panelHeader.Controls.Add(btnLogOut);
            panelHeader.Controls.Add(lbHeader);
            panelHeader.Controls.Add(pictureBox1);
            panelHeader.Dock = DockStyle.Top;
            panelHeader.Location = new Point(0, 0);
            panelHeader.Name = "panelHeader";
            panelHeader.Size = new Size(687, 125);
            panelHeader.TabIndex = 0;
            // 
            // frmMain
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(9F, 21F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.Window;
            BackgroundImageLayout = ImageLayout.None;
            ClientSize = new Size(687, 289);
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
            panelFooter.ResumeLayout(false);
            panelFooter.PerformLayout();
            panelMain.ResumeLayout(false);
            panelSelect.ResumeLayout(false);
            panelSelect.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)pictureBox1).EndInit();
            panelHeader.ResumeLayout(false);
            panelHeader.PerformLayout();
            ResumeLayout(false);
        }

        #endregion
        private Panel panelFooter;
        private Label label1;
        private Label labelFooter;
        private Panel panelMain;
        private Panel panelSelect;
        private ComboBox cbStation;
        private Label labelSelect;
        private Button btnProcess;
        private PictureBox pictureBox1;
        private Label lbHeader;
        private Button btnLogOut;
        private Button btnTrain;
        private Button btnRedirect;
        private Button btnPermission;
        private Panel panelHeader;
    }
}
