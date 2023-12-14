namespace NganGiang
{
    partial class frmLogin
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
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
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmLogin));
            panelHeader = new Panel();
            pictureBox1 = new PictureBox();
            panelFooter = new Panel();
            lbFooter = new Label();
            panelMain = new Panel();
            panel1 = new Panel();
            btnLogIn = new Button();
            txtPassword = new TextBox();
            lbPassword = new Label();
            txtUsername = new TextBox();
            lbUsername = new Label();
            panelHeader.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)pictureBox1).BeginInit();
            panelFooter.SuspendLayout();
            panelMain.SuspendLayout();
            panel1.SuspendLayout();
            SuspendLayout();
            // 
            // panelHeader
            // 
            panelHeader.BackColor = SystemColors.Window;
            panelHeader.Controls.Add(pictureBox1);
            panelHeader.Dock = DockStyle.Top;
            panelHeader.Location = new Point(0, 0);
            panelHeader.Name = "panelHeader";
            panelHeader.Size = new Size(493, 105);
            panelHeader.TabIndex = 4;
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
            panelFooter.BackColor = SystemColors.Window;
            panelFooter.Controls.Add(lbFooter);
            panelFooter.Dock = DockStyle.Bottom;
            panelFooter.Location = new Point(0, 288);
            panelFooter.Margin = new Padding(4);
            panelFooter.Name = "panelFooter";
            panelFooter.Size = new Size(493, 70);
            panelFooter.TabIndex = 5;
            // 
            // lbFooter
            // 
            lbFooter.AutoSize = true;
            lbFooter.Location = new Point(44, 20);
            lbFooter.Margin = new Padding(4, 0, 4, 0);
            lbFooter.Name = "lbFooter";
            lbFooter.Size = new Size(372, 28);
            lbFooter.TabIndex = 3;
            lbFooter.Text = "© Copyright 2023 Ngan Giang company.";
            lbFooter.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // panelMain
            // 
            panelMain.BackColor = SystemColors.Window;
            panelMain.Controls.Add(panel1);
            panelMain.Dock = DockStyle.Fill;
            panelMain.Location = new Point(0, 0);
            panelMain.Name = "panelMain";
            panelMain.Size = new Size(493, 358);
            panelMain.TabIndex = 6;
            // 
            // panel1
            // 
            panel1.BackColor = SystemColors.Window;
            panel1.Controls.Add(btnLogIn);
            panel1.Controls.Add(txtPassword);
            panel1.Controls.Add(lbPassword);
            panel1.Controls.Add(txtUsername);
            panel1.Controls.Add(lbUsername);
            panel1.Dock = DockStyle.Fill;
            panel1.Location = new Point(0, 0);
            panel1.Name = "panel1";
            panel1.Size = new Size(493, 358);
            panel1.TabIndex = 7;
            // 
            // btnLogIn
            // 
            btnLogIn.AutoSize = true;
            btnLogIn.BackColor = Color.FromArgb(43, 76, 114);
            btnLogIn.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            btnLogIn.ForeColor = SystemColors.ControlLightLight;
            btnLogIn.Location = new Point(146, 221);
            btnLogIn.Name = "btnLogIn";
            btnLogIn.Size = new Size(158, 44);
            btnLogIn.TabIndex = 3;
            btnLogIn.Text = "Đăng nhập";
            btnLogIn.UseVisualStyleBackColor = false;
            btnLogIn.Click += btnLogIn_Click;
            // 
            // txtPassword
            // 
            txtPassword.Anchor = AnchorStyles.Top;
            txtPassword.Location = new Point(205, 161);
            txtPassword.Name = "txtPassword";
            txtPassword.PasswordChar = '*';
            txtPassword.Size = new Size(232, 34);
            txtPassword.TabIndex = 2;
            // 
            // lbPassword
            // 
            lbPassword.Anchor = AnchorStyles.Top;
            lbPassword.AutoSize = true;
            lbPassword.Location = new Point(61, 163);
            lbPassword.Name = "lbPassword";
            lbPassword.Size = new Size(94, 28);
            lbPassword.TabIndex = 2;
            lbPassword.Text = "Mật khẩu";
            // 
            // txtUsername
            // 
            txtUsername.Anchor = AnchorStyles.Top;
            txtUsername.Location = new Point(205, 121);
            txtUsername.Name = "txtUsername";
            txtUsername.Size = new Size(232, 34);
            txtUsername.TabIndex = 1;
            // 
            // lbUsername
            // 
            lbUsername.Anchor = AnchorStyles.Top;
            lbUsername.AutoSize = true;
            lbUsername.Location = new Point(61, 123);
            lbUsername.Name = "lbUsername";
            lbUsername.Size = new Size(140, 28);
            lbUsername.TabIndex = 2;
            lbUsername.Text = "Tên đăng nhập";
            // 
            // frmLogin
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(493, 358);
            Controls.Add(panelHeader);
            Controls.Add(panelFooter);
            Controls.Add(panelMain);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frmLogin";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Đăng nhập";
            panelHeader.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)pictureBox1).EndInit();
            panelFooter.ResumeLayout(false);
            panelFooter.PerformLayout();
            panelMain.ResumeLayout(false);
            panel1.ResumeLayout(false);
            panel1.PerformLayout();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelHeader;
        private PictureBox pictureBox1;
        private Panel panelFooter;
        private Label lbFooter;
        private Panel panelMain;
        private Panel panel1;
        private TextBox txtUsername;
        private Label lbUsername;
        private TextBox txtPassword;
        private Label lbPassword;
        private Button btnLogIn;
    }
}