namespace NganGiang.Views
{
    partial class frm402
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
            DataGridViewCellStyle dataGridViewCellStyle1 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle2 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle3 = new DataGridViewCellStyle();
            DataGridViewCellStyle dataGridViewCellStyle4 = new DataGridViewCellStyle();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frm402));
            panelDGV = new Panel();
            dgv402 = new DataGridView();
            IsSelected = new DataGridViewCheckBoxColumn();
            btnProcess = new Button();
            lbHeader = new Label();
            panelDGV.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgv402).BeginInit();
            SuspendLayout();
            // 
            // panelDGV
            // 
            panelDGV.Anchor = AnchorStyles.Top | AnchorStyles.Bottom | AnchorStyles.Left | AnchorStyles.Right;
            panelDGV.Controls.Add(dgv402);
            panelDGV.Location = new Point(16, 78);
            panelDGV.Margin = new Padding(6);
            panelDGV.Name = "panelDGV";
            panelDGV.Size = new Size(1312, 379);
            panelDGV.TabIndex = 22;
            // 
            // dgv402
            // 
            dgv402.AllowDrop = true;
            dgv402.AllowUserToAddRows = false;
            dgv402.AllowUserToDeleteRows = false;
            dgv402.AllowUserToResizeColumns = false;
            dgv402.AllowUserToResizeRows = false;
            dgv402.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
            dgv402.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCells;
            dgv402.BackgroundColor = SystemColors.ControlLightLight;
            dgv402.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = SystemColors.Control;
            dataGridViewCellStyle1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 0);
            dataGridViewCellStyle1.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle1.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle1.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle1.WrapMode = DataGridViewTriState.False;
            dgv402.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            dgv402.ColumnHeadersHeight = 60;
            dgv402.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            dgv402.Columns.AddRange(new DataGridViewColumn[] { IsSelected });
            dataGridViewCellStyle2.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle2.BackColor = SystemColors.Window;
            dataGridViewCellStyle2.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle2.ForeColor = SystemColors.ControlText;
            dataGridViewCellStyle2.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle2.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle2.WrapMode = DataGridViewTriState.False;
            dgv402.DefaultCellStyle = dataGridViewCellStyle2;
            dgv402.Dock = DockStyle.Fill;
            dgv402.Location = new Point(0, 0);
            dgv402.Margin = new Padding(4);
            dgv402.MultiSelect = false;
            dgv402.Name = "dgv402";
            dataGridViewCellStyle3.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.BackColor = SystemColors.Control;
            dataGridViewCellStyle3.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dataGridViewCellStyle3.ForeColor = SystemColors.WindowText;
            dataGridViewCellStyle3.SelectionBackColor = SystemColors.Highlight;
            dataGridViewCellStyle3.SelectionForeColor = SystemColors.HighlightText;
            dataGridViewCellStyle3.WrapMode = DataGridViewTriState.True;
            dgv402.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
            dgv402.RowHeadersVisible = false;
            dgv402.RowHeadersWidth = 51;
            dataGridViewCellStyle4.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle4.Font = new Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, 0);
            dgv402.RowsDefaultCellStyle = dataGridViewCellStyle4;
            dgv402.ScrollBars = ScrollBars.Vertical;
            dgv402.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            dgv402.Size = new Size(1312, 379);
            dgv402.TabIndex = 3;
            dgv402.CellFormatting += dgv402_CellFormatting;
            // 
            // IsSelected
            // 
            IsSelected.FillWeight = 13F;
            IsSelected.HeaderText = "";
            IsSelected.MinimumWidth = 6;
            IsSelected.Name = "IsSelected";
            // 
            // btnProcess
            // 
            btnProcess.Anchor = AnchorStyles.Bottom | AnchorStyles.Right;
            btnProcess.BackColor = Color.FromArgb(43, 76, 114);
            btnProcess.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            btnProcess.ForeColor = SystemColors.Control;
            btnProcess.Location = new Point(1068, 469);
            btnProcess.Margin = new Padding(6);
            btnProcess.Name = "btnProcess";
            btnProcess.Size = new Size(260, 65);
            btnProcess.TabIndex = 21;
            btnProcess.Text = "Rót nguyên liệu rắn";
            btnProcess.UseVisualStyleBackColor = false;
            btnProcess.Click += btnProcess_Click;
            // 
            // lbHeader
            // 
            lbHeader.BackColor = Color.FromArgb(43, 76, 114);
            lbHeader.Font = new Font("Segoe UI", 14F, FontStyle.Bold);
            lbHeader.ForeColor = SystemColors.Control;
            lbHeader.Location = new Point(16, 12);
            lbHeader.Margin = new Padding(6, 0, 6, 0);
            lbHeader.Name = "lbHeader";
            lbHeader.Size = new Size(270, 56);
            lbHeader.TabIndex = 20;
            lbHeader.Text = "Xử lý tại trạm 402";
            lbHeader.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // frm402
            // 
            AcceptButton = btnProcess;
            AutoScaleDimensions = new SizeF(8F, 20F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1345, 546);
            Controls.Add(panelDGV);
            Controls.Add(btnProcess);
            Controls.Add(lbHeader);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "frm402";
            Text = "Trạm 402";
            WindowState = FormWindowState.Maximized;
            Load += frm402_Load;
            panelDGV.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgv402).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private Panel panelDGV;
        private Button btnProcess;
        private Label lbHeader;
        private DataGridView dgv402;
        private DataGridViewCheckBoxColumn IsSelected;
    }
}