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
            DataGridViewCellStyle dataGridViewCellStyle1 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle2 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle3 = new DataGridViewCellStyle();
            panelHeading = new Panel();
            pictureBox1 = new PictureBox();
            panelFooter = new Panel();
            labelFooter = new Label();
            panel1 = new Panel();
            panelDGV = new Panel();
            dgv403 = new DataGridView();
            Column1 = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            panel2 = new Panel();
            lbHeader = new Label();
            panelHeading.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)pictureBox1).BeginInit();
            panelFooter.SuspendLayout();
            panel1.SuspendLayout();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv403).BeginInit();
            panel2.SuspendLayout();
            SuspendLayout();
            // 
            // panelHeading
            // 
            panelHeading.Controls.Add(pictureBox1);
            panelHeading.Dock = DockStyle.Top;
            panelHeading.Location = new Point(0, 0);
            panelHeading.Margin = new Padding(4);
            panelHeading.Name = "panelHeading";
            panelHeading.Size = new Size(1100, 96);
            panelHeading.TabIndex = 0;
            // 
            // pictureBox1
            // 
            pictureBox1.Image = Properties.Resources.logo;
            pictureBox1.Location = new Point(16, 17);
            pictureBox1.Margin = new Padding(4);
            pictureBox1.Name = "pictureBox1";
            pictureBox1.Size = new Size(150, 50);
            pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
            pictureBox1.TabIndex = 0;
            pictureBox1.TabStop = false;
            // 
            // panelFooter
            // 
            panelFooter.Controls.Add(labelFooter);
            panelFooter.Dock = DockStyle.Bottom;
            panelFooter.Location = new Point(0, 653);
            panelFooter.Margin = new Padding(4);
            panelFooter.Name = "panelFooter";
            panelFooter.Size = new Size(1100, 95);
            panelFooter.TabIndex = 1;
            // 
            // labelFooter
            // 
            labelFooter.Anchor = AnchorStyles.None;
            labelFooter.AutoSize = true;
            labelFooter.Location = new Point(331, 36);
            labelFooter.Margin = new Padding(4, 0, 4, 0);
            labelFooter.Name = "labelFooter";
            labelFooter.Size = new Size(372, 28);
            labelFooter.TabIndex = 0;
            labelFooter.Text = "© Copyright 2023 Ngan Giang company.";
            labelFooter.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // panel1
            // 
            panel1.Controls.Add(panelDGV);
            panel1.Controls.Add(btnProcess);
            panel1.Controls.Add(panel2);
            panel1.Dock = DockStyle.Fill;
            panel1.Location = new Point(0, 96);
            panel1.Margin = new Padding(4);
            panel1.Name = "panel1";
            panel1.Size = new Size(1100, 557);
            panel1.TabIndex = 1;
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv403);
            panelDGV.Location = new Point(16, 70);
            panelDGV.Margin = new Padding(4);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1071, 409);
            panelDGV.TabIndex = 3;
            // 
            // dgv403
            // 
            dgv403.AllowUserToAddRows = false;
            dgv403.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv403.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.AllCells;
            dgv403.BackgroundColor = SystemColors.Control;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.True;
            dgv403.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv403.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgv403.Columns.AddRange(new DataGridViewColumn[] { Column1 });
            dgv403.Dock = DockStyle.Fill;
            dgv403.Location = new Point(0, 0);
            dgv403.Margin = new Padding(4);
            dgv403.MultiSelect = false;
            dgv403.Name = "dgv403";
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Control;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv403.RowHeadersDefaultCellStyle = dataGridViewCellStyle2;
            dgv403.RowHeadersWidth = 51;
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgv403.RowsDefaultCellStyle = dataGridViewCellStyle3;
            dgv403.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv403.Size = new Size(1071, 409);
            dgv403.TabIndex = 2;
            dgv403.CellFormatting += dgv403_CellFormatting;
            // 
            // Column1
            // 
            Column1.AutoSizeMode = DataGridViewAutoSizeColumnMode.DisplayedCells;
            Column1.HeaderText = "";
            Column1.MinimumWidth = 6;
            Column1.Name = "Column1";
            Column1.Resizable = DataGridViewTriState.False;
            Column1.Width = 6;
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(887, 490);
            btnProcess.Margin = new Padding(4);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(200, 63);
            btnProcess.TabIndex = 2;
            btnProcess.Text = "Rót nguyên liệu rắn";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // panel2
            // 
            panel2.BackColor = Color.FromArgb(43, 76, 114);
            panel2.Controls.Add(lbHeader);
            panel2.Location = new Point(16, 11);
            panel2.Margin = new Padding(4);
            panel2.Name = "panel2";
            panel2.Size = new Size(195, 50);
            panel2.TabIndex = 0;
            // 
            // lbHeader
            // 
            lbHeader.Anchor = AnchorStyles.None;
            lbHeader.AutoSize = true;
            lbHeader.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(4, 11);
            lbHeader.Margin = new Padding(4, 0, 4, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(175, 28);
            lbHeader.TabIndex = 0;
            lbHeader.Text = "Xử lý tại kho 403";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frmMain
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.Window;
            ClientSize = new Size(1100, 748);
            Controls.Add(panel1);
            Controls.Add(panelFooter);
            Controls.Add(panelHeading);
            Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            Margin = new Padding(4);
            Name = "frmMain";
            Text = "Trạm 403";
            Load += frmMain_Load;
            panelHeading.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)pictureBox1).EndInit();
            panelFooter.ResumeLayout(false);
            panelFooter.PerformLayout();
            panel1.ResumeLayout(false);
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv403).EndInit();
            panel2.ResumeLayout(false);
            panel2.PerformLayout();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelHeading;
        private PictureBox pictureBox1;
        private Panel panelFooter;
        private Label labelFooter;
        private Panel panel1;
        private Panel panel2;
        private Label lbHeader;
        private Button btnProcess;
        private Panel panelDGV;
        private DataGridView dgv403;
        private DataGridViewCheckBoxColumn Column1;
    }
}
