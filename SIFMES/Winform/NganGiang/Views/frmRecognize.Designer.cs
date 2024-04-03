namespace NganGiang.Views
{
    partial class frmRecognize
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmRecognize));
            picBoxRecognize = new PictureBox();
            btnRecognize = new Button();
            ((System.ComponentModel.ISupportInitialize)picBoxRecognize).BeginInit();
            SuspendLayout();
            // 
            // picBoxRecognize
            // 
            picBoxRecognize.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            picBoxRecognize.Location = new Point(12, 12);
            picBoxRecognize.Name = "picBoxRecognize";
            picBoxRecognize.Size = new Size(799, 422);
            picBoxRecognize.TabIndex = 0;
            picBoxRecognize.TabStop = false;
            // 
            // btnRecognize
            // 
            btnRecognize.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            btnRecognize.BackColor = Color.FromArgb(43, 76, 114);
            btnRecognize.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            btnRecognize.ForeColor = SystemColors.ControlLightLight;
            btnRecognize.Location = new Point(674, 449);
            btnRecognize.Name = "btnRecognize";
            btnRecognize.Size = new Size(137, 46);
            btnRecognize.TabIndex = 1;
            btnRecognize.Text = "Nhận diện";
            btnRecognize.UseVisualStyleBackColor = false;
            btnRecognize.Click += btnRecognize_Click;
            // 
            // frmRecognize
            // 
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(821, 540);
            Controls.Add(btnRecognize);
            Controls.Add(picBoxRecognize);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "frmRecognize";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Nhận diện khuôn mặt";
            FormClosing += frmRecognize_FormClosing;
            Load += frmRecognize_Load;
            ((System.ComponentModel.ISupportInitialize)picBoxRecognize).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private PictureBox picBoxRecognize;
        private Button btnRecognize;
    }
}