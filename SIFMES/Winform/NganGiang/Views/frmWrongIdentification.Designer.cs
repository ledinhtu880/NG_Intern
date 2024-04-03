namespace NganGiang.Views
{
    partial class frmWrongIdentification
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmWrongIdentification));
            panel1 = new Panel();
            btnDeleteAll = new Button();
            dtpkDate = new DateTimePicker();
            btnShowAll = new Button();
            label1 = new Label();
            panel2 = new Panel();
            dgvReport = new DataGridView();
            STT = new DataGridViewTextBoxColumn();
            ImageIdentification = new DataGridViewImageColumn();
            WrongIdentificationName = new DataGridViewTextBoxColumn();
            CorrectIdentificationName = new DataGridViewComboBoxColumn();
            btnTrain = new DataGridViewButtonColumn();
            btnDelete = new DataGridViewButtonColumn();
            panel1.SuspendLayout();
            panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvReport).BeginInit();
            SuspendLayout();
            // 
            // panel1
            // 
            panel1.Controls.Add(btnDeleteAll);
            panel1.Controls.Add(dtpkDate);
            panel1.Controls.Add(btnShowAll);
            panel1.Controls.Add(label1);
            panel1.Dock = DockStyle.Top;
            panel1.Location = new Point(0, 0);
            panel1.Name = "panel1";
            panel1.Size = new Size(1452, 125);
            panel1.TabIndex = 0;
            // 
            // btnDeleteAll
            // 
            btnDeleteAll.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            btnDeleteAll.AutoSize = true;
            btnDeleteAll.Location = new Point(1045, 13);
            btnDeleteAll.Name = "btnDeleteAll";
            btnDeleteAll.Size = new Size(395, 41);
            btnDeleteAll.TabIndex = 22;
            btnDeleteAll.Text = "Xóa tất cả hình ảnh chưa được nhận diện";
            btnDeleteAll.UseVisualStyleBackColor = true;
            btnDeleteAll.Click += btnDeleteAll_Click;
            // 
            // dtpkDate
            // 
            dtpkDate.Location = new Point(136, 14);
            dtpkDate.Name = "dtpkDate";
            dtpkDate.Size = new Size(250, 34);
            dtpkDate.TabIndex = 19;
            dtpkDate.ValueChanged += dtpkDate_ValueChanged;
            // 
            // btnShowAll
            // 
            btnShowAll.AutoSize = true;
            btnShowAll.Location = new Point(402, 12);
            btnShowAll.Name = "btnShowAll";
            btnShowAll.Size = new Size(94, 38);
            btnShowAll.TabIndex = 21;
            btnShowAll.Text = "Tất cả";
            btnShowAll.UseVisualStyleBackColor = true;
            btnShowAll.Click += btnShowAll_Click;
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(19, 16);
            label1.Margin = new Padding(4, 0, 4, 0);
            label1.Name = "label1";
            label1.Size = new Size(106, 28);
            label1.TabIndex = 18;
            label1.Text = "Chọn ngày";
            // 
            // panel2
            // 
            panel2.Controls.Add(dgvReport);
            panel2.Dock = DockStyle.Fill;
            panel2.Location = new Point(0, 125);
            panel2.Name = "panel2";
            panel2.Size = new Size(1452, 498);
            panel2.TabIndex = 0;
            // 
            // dgvReport
            // 
            dgvReport.AllowUserToAddRows = false;
            dgvReport.AllowUserToDeleteRows = false;
            dgvReport.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgvReport.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.AllCellsExceptHeaders;
            dgvReport.BackgroundColor = SystemColors.AppWorkspace;
            dgvReport.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvReport.Columns.AddRange(new DataGridViewColumn[] { STT, ImageIdentification, WrongIdentificationName, CorrectIdentificationName, btnTrain, btnDelete });
            dgvReport.Dock = DockStyle.Fill;
            dgvReport.Location = new Point(0, 0);
            dgvReport.Name = "dgvReport";
            dgvReport.RowHeadersWidth = 51;
            dgvReport.Size = new Size(1452, 498);
            dgvReport.TabIndex = 20;
            dgvReport.CellClick += dgvReport_CellClick;
            // 
            // STT
            // 
            STT.FillWeight = 50F;
            STT.HeaderText = "STT";
            STT.MinimumWidth = 6;
            STT.Name = "STT";
            STT.ReadOnly = true;
            STT.SortMode = DataGridViewColumnSortMode.NotSortable;
            // 
            // ImageIdentification
            // 
            ImageIdentification.FillWeight = 71.1591644F;
            ImageIdentification.HeaderText = "Ảnh nhận diện";
            ImageIdentification.MinimumWidth = 6;
            ImageIdentification.Name = "ImageIdentification";
            ImageIdentification.ReadOnly = true;
            // 
            // WrongIdentificationName
            // 
            WrongIdentificationName.HeaderText = "Tên nhận diện sai";
            WrongIdentificationName.MinimumWidth = 6;
            WrongIdentificationName.Name = "WrongIdentificationName";
            WrongIdentificationName.ReadOnly = true;
            WrongIdentificationName.SortMode = DataGridViewColumnSortMode.NotSortable;
            // 
            // CorrectIdentificationName
            // 
            CorrectIdentificationName.HeaderText = "Tên nhận diện đúng";
            CorrectIdentificationName.MinimumWidth = 6;
            CorrectIdentificationName.Name = "CorrectIdentificationName";
            CorrectIdentificationName.Resizable = DataGridViewTriState.True;
            // 
            // btnTrain
            // 
            btnTrain.HeaderText = "Huấn luyện";
            btnTrain.MinimumWidth = 6;
            btnTrain.Name = "btnTrain";
            btnTrain.ReadOnly = true;
            btnTrain.Resizable = DataGridViewTriState.True;
            // 
            // btnDelete
            // 
            btnDelete.HeaderText = "Hành động";
            btnDelete.MinimumWidth = 6;
            btnDelete.Name = "btnDelete";
            // 
            // frmWrongIdentification
            // 
            AutoScaleDimensions = new SizeF(11F, 28F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1452, 623);
            Controls.Add(panel2);
            Controls.Add(panel1);
            Font = new Font("Segoe UI", 12F);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Margin = new Padding(4);
            Name = "frmWrongIdentification";
            StartPosition = FormStartPosition.CenterScreen;
            Text = "Danh sách khuôn mặt không xác định";
            panel1.ResumeLayout(false);
            panel1.PerformLayout();
            panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgvReport).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panel1;
        private DateTimePicker dtpkDate;
        private Button btnShowAll;
        private Label label1;
        private Panel panel2;
        private DataGridView dgvReport;
        private Button btnDeleteAll;
        private DataGridViewTextBoxColumn STT;
        private DataGridViewImageColumn ImageIdentification;
        private DataGridViewTextBoxColumn WrongIdentificationName;
        private DataGridViewComboBoxColumn CorrectIdentificationName;
        private DataGridViewButtonColumn btnTrain;
        private DataGridViewButtonColumn btnDelete;
    }
}