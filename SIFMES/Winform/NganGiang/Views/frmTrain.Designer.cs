namespace NganGiang.Views
{
    partial class frmTrain
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmTrain));
            label1 = new Label();
            txtUser = new TextBox();
            picBoxTrain = new PictureBox();
            btnTake = new Button();
            btnTrain = new Button();
            ((System.ComponentModel.ISupportInitialize)picBoxTrain).BeginInit();
            SuspendLayout();
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(16, 12);
            label1.Margin = new Padding(4, 0, 4, 0);
            label1.Name = "label1";
            label1.Size = new Size(41, 28);
            label1.TabIndex = 0;
            label1.Text = "Tên";
            // 
            // txtUser
            // 
            txtUser.Location = new Point(69, 9);
            txtUser.Margin = new Padding(4);
            txtUser.Name = "txtUser";
            txtUser.ReadOnly = true;
            txtUser.Size = new Size(225, 34);
            txtUser.TabIndex = 1;
            // 
            // picBoxTrain
            // 
            picBoxTrain.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            picBoxTrain.Location = new Point(16, 67);
            picBoxTrain.Margin = new Padding(4);
            picBoxTrain.Name = "picBoxTrain";
            picBoxTrain.Size = new Size(980, 515);
            picBoxTrain.TabIndex = 2;
            picBoxTrain.TabStop = false;
            // 
            // btnTake
            // 
            btnTake.Location = new Point(16, 603);
            btnTake.Margin = new Padding(4);
            btnTake.Name = "btnTake";
            btnTake.Size = new Size(179, 56);
            btnTake.TabIndex = 6;
            btnTake.Text = "Chụp ảnh";
            btnTake.UseVisualStyleBackColor = true;
            btnTake.Click += btnTake_Click;
            // 
            // btnTrain
            // 
            btnTrain.Location = new Point(839, 603);
            btnTrain.Margin = new Padding(4);
            btnTrain.Name = "btnTrain";
            btnTrain.Size = new Size(158, 53);
            btnTrain.TabIndex = 7;
            btnTrain.Text = "Huấn luyện";
            btnTrain.UseVisualStyleBackColor = true;
            btnTrain.Click += btnTrain_Click;
            // 
            // frmTrain
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1015, 673);
            Controls.Add(btnTrain);
            Controls.Add(btnTake);
            Controls.Add(picBoxTrain);
            Controls.Add(txtUser);
            Controls.Add(label1);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frmTrain";
            Text = "Huấn luyện khuôn mặt";
            FormClosing += frmTrain_FormClosing;
            Load += frmTrain_Load;
            ((System.ComponentModel.ISupportInitialize)picBoxTrain).EndInit();
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label label1;
        private TextBox txtUser;
        private PictureBox picBoxTrain;
        private Button btnCamera;
        private Button btnTake;
        private Button btnTrain;
    }
}