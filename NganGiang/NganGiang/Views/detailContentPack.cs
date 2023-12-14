using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using NganGiang.Libs;

namespace NganGiang.Views
{
    public partial class detailContentPack : Form
    {
        private string Id_ContentPack;
        public detailContentPack()
        {
            InitializeComponent();
        }
        public void SetPackContentID(string id)
        {
            Id_ContentPack = id;
        }
        private void detailContentPack408_Load(object sender, EventArgs e)
        {
            lbHeader.Text = "Thông tin chi tiết gói hàng số " + this.Id_ContentPack;
            string query = $"select FK_ID_PackContent as [Mã gói hàng], Id_SimpleContent as [Mã thùng hàng], " +
                $"Name_RawMaterial as [Tên nguyên liệu thô], Count_RawMaterial as [Số lượng nguyên liệu], " +
                $"Name_ContainerType as [Loại thùng chứa], Count_Container as [Số lượng thùng chứa], " +
                $"CASE WHEN DH.FK_Id_SimpleContent IS NULL THEN N'Chưa có' ELSE N'Đã có' END AS [Trạng thái thùng hàng]" +
                $"from ContentSimple " +
                $"inner join DetailContentSimpleOfPack on Id_SimpleContent = FK_Id_SimpleContent " +
                $"inner join RawMaterial on Id_RawMaterial = FK_Id_RawMaterial " +
                $"inner join ContainerType on Id_ContainerType = FK_Id_ContainerType " +
                $"left join DetailStateCellOfSimpleWareHouse DH on Id_SimpleContent = DH.FK_Id_SimpleContent " +
                $"where FK_Id_PackContent = {Id_ContentPack}";
            dgvDetailContentPack.DataSource = DataProvider.Instance.ExecuteQuery(query);
        }

        private void btnBack_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
