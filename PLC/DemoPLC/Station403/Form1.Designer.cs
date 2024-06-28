namespace Station403
{
    partial class Form1
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
            this.components = new System.ComponentModel.Container();
            this.timer1 = new System.Windows.Forms.Timer(this.components);
            this.timer2 = new System.Windows.Forms.Timer(this.components);
            this.lbStatus = new System.Windows.Forms.Label();
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.lbStation = new System.Windows.Forms.Label();
            this.numericUpDown1 = new System.Windows.Forms.NumericUpDown();
            this.lbRFID = new System.Windows.Forms.Label();
            this.txtRFID = new System.Windows.Forms.TextBox();
            this.numCountContainer = new System.Windows.Forms.NumericUpDown();
            this.lbCountContainer = new System.Windows.Forms.Label();
            this.numContainerType = new System.Windows.Forms.NumericUpDown();
            this.lbRawMaterialType = new System.Windows.Forms.Label();
            this.numRawMaterialType = new System.Windows.Forms.NumericUpDown();
            this.label1 = new System.Windows.Forms.Label();
            this.groupBox1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.numericUpDown1)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.numCountContainer)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.numContainerType)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.numRawMaterialType)).BeginInit();
            this.SuspendLayout();
            // 
            // timer1
            // 
            this.timer1.Enabled = true;
            this.timer1.Interval = 1000;
            this.timer1.Tick += new System.EventHandler(this.timer1_Tick);
            // 
            // lbStatus
            // 
            this.lbStatus.AutoSize = true;
            this.lbStatus.Location = new System.Drawing.Point(16, 14);
            this.lbStatus.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.lbStatus.Name = "lbStatus";
            this.lbStatus.Size = new System.Drawing.Size(79, 24);
            this.lbStatus.TabIndex = 0;
            this.lbStatus.Text = "Status: ";
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.numRawMaterialType);
            this.groupBox1.Controls.Add(this.label1);
            this.groupBox1.Controls.Add(this.numContainerType);
            this.groupBox1.Controls.Add(this.lbRawMaterialType);
            this.groupBox1.Controls.Add(this.numCountContainer);
            this.groupBox1.Controls.Add(this.lbCountContainer);
            this.groupBox1.Controls.Add(this.txtRFID);
            this.groupBox1.Controls.Add(this.lbRFID);
            this.groupBox1.Controls.Add(this.numericUpDown1);
            this.groupBox1.Controls.Add(this.lbStation);
            this.groupBox1.Location = new System.Drawing.Point(20, 52);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(461, 308);
            this.groupBox1.TabIndex = 1;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Data";
            // 
            // lbStation
            // 
            this.lbStation.AutoSize = true;
            this.lbStation.Location = new System.Drawing.Point(11, 41);
            this.lbStation.Name = "lbStation";
            this.lbStation.Size = new System.Drawing.Size(73, 24);
            this.lbStation.TabIndex = 0;
            this.lbStation.Text = "Station";
            // 
            // numericUpDown1
            // 
            this.numericUpDown1.Location = new System.Drawing.Point(222, 37);
            this.numericUpDown1.Name = "numericUpDown1";
            this.numericUpDown1.Size = new System.Drawing.Size(120, 32);
            this.numericUpDown1.TabIndex = 1;
            // 
            // lbRFID
            // 
            this.lbRFID.AutoSize = true;
            this.lbRFID.Location = new System.Drawing.Point(11, 215);
            this.lbRFID.Name = "lbRFID";
            this.lbRFID.Size = new System.Drawing.Size(53, 24);
            this.lbRFID.TabIndex = 2;
            this.lbRFID.Text = "RFID";
            // 
            // txtRFID
            // 
            this.txtRFID.Location = new System.Drawing.Point(222, 215);
            this.txtRFID.Name = "txtRFID";
            this.txtRFID.Size = new System.Drawing.Size(120, 32);
            this.txtRFID.TabIndex = 3;
            // 
            // numCountContainer
            // 
            this.numCountContainer.Location = new System.Drawing.Point(222, 79);
            this.numCountContainer.Name = "numCountContainer";
            this.numCountContainer.Size = new System.Drawing.Size(120, 32);
            this.numCountContainer.TabIndex = 5;
            // 
            // lbCountContainer
            // 
            this.lbCountContainer.AutoSize = true;
            this.lbCountContainer.Location = new System.Drawing.Point(11, 83);
            this.lbCountContainer.Name = "lbCountContainer";
            this.lbCountContainer.Size = new System.Drawing.Size(194, 24);
            this.lbCountContainer.TabIndex = 4;
            this.lbCountContainer.Text = "Số lượng thùng chứa";
            // 
            // numContainerType
            // 
            this.numContainerType.Location = new System.Drawing.Point(222, 124);
            this.numContainerType.Name = "numContainerType";
            this.numContainerType.Size = new System.Drawing.Size(120, 32);
            this.numContainerType.TabIndex = 7;
            // 
            // lbRawMaterialType
            // 
            this.lbRawMaterialType.AutoSize = true;
            this.lbRawMaterialType.Location = new System.Drawing.Point(11, 128);
            this.lbRawMaterialType.Name = "lbRawMaterialType";
            this.lbRawMaterialType.Size = new System.Drawing.Size(153, 24);
            this.lbRawMaterialType.TabIndex = 6;
            this.lbRawMaterialType.Text = "Loại thùng chứa";
            // 
            // numRawMaterialType
            // 
            this.numRawMaterialType.Location = new System.Drawing.Point(222, 168);
            this.numRawMaterialType.Name = "numRawMaterialType";
            this.numRawMaterialType.Size = new System.Drawing.Size(120, 32);
            this.numRawMaterialType.TabIndex = 9;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(11, 172);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(156, 24);
            this.label1.TabIndex = 8;
            this.label1.Text = "Loại nguyên liệu";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(11F, 24F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(502, 384);
            this.Controls.Add(this.groupBox1);
            this.Controls.Add(this.lbStatus);
            this.Font = new System.Drawing.Font("Tahoma", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.Margin = new System.Windows.Forms.Padding(4, 4, 4, 4);
            this.Name = "Form1";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Form1";
            this.groupBox1.ResumeLayout(false);
            this.groupBox1.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.numericUpDown1)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.numCountContainer)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.numContainerType)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.numRawMaterialType)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Timer timer1;
        private System.Windows.Forms.Timer timer2;
        private System.Windows.Forms.Label lbStatus;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.NumericUpDown numericUpDown1;
        private System.Windows.Forms.Label lbStation;
        private System.Windows.Forms.Label lbRFID;
        private System.Windows.Forms.TextBox txtRFID;
        private System.Windows.Forms.NumericUpDown numCountContainer;
        private System.Windows.Forms.Label lbCountContainer;
        private System.Windows.Forms.NumericUpDown numContainerType;
        private System.Windows.Forms.Label lbRawMaterialType;
        private System.Windows.Forms.NumericUpDown numRawMaterialType;
        private System.Windows.Forms.Label label1;
    }
}

