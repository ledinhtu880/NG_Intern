
using NganGiang.Libs;
using System.Data;
using System.Data.SqlClient;

namespace NganGiang.Services.Process
{
    internal class ProcessService412
    {
        public ProcessService412()
        {
        }
        public DataTable getProcessAt412()
        {
            string query = "SELECT DCPOL.FK_Id_OrderLocal, PCP.FK_Id_ContentPack, S.Name_State, " +
                "FORMAT(OL.Date_Start, 'dd-MM-yyyy') AS Date_Start " +
                "FROM ProcessContentPack PCP " +
                "INNER JOIN DetailContentPackOrderLocal DCPOL ON PCP.FK_Id_ContentPack = DCPOL.FK_Id_ContentPack " +
                "INNER JOIN [State] S ON S.Id_State = PCP.FK_Id_State " +
                "INNER JOIN OrderLocal OL ON OL.Id_OrderLocal = DCPOL.FK_Id_OrderLocal " +
                "WHERE PCP.FK_Id_Station = 412 AND PCP.FK_Id_State = 0 AND OL.Date_Fin IS NULL";
            return DataProvider.Instance.ExecuteQuery(query);
        }

        public DataTable getInforContentSimpleByContentPack(int id_pack)
        {
            string query = $"SELECT FK_Id_ContentSimple as N'Mã thùng hàng', Name_RawMaterial as N'Nguyên liệu', Count_RawMaterial as N'Số lượng nguyên liệu',\r\nUnit as N'Đơn vị', Name_ContainerType as N'Thùng chứa',\r\nCount_Container as N'Số lượng thùng chứa', format(Price_Container, '##,###.## VNĐ') as N'Đơn giá'\r\nFROM ContentSimple CS\r\nINNER JOIN DetailContentSimpleOfPack DCSOP ON DCSOP.FK_Id_ContentSimple = CS.Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN ContainerType on FK_Id_ContainerType = Id_ContainerType\r\nWHERE DCSOP.FK_Id_ContentPack = {id_pack}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }

        List<int> id_content_simple = new List<int>();
        private void getIdContentSimple(int id_pack)
        {
            id_content_simple.Clear();
            string query = $"select distinct Id_ContentSimple from DetailContentSimpleOfPack DL join ContentSimple C on DL.FK_Id_ContentSimple = C.Id_ContentSimple where DL.FK_Id_ContentPack = {id_pack}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow dr in dt.Rows)
                {
                    id_content_simple.Add(Convert.ToInt32(dr[0]));
                }
            }
        }

        public void UpdateProcessPackAndOrder(int id_pack)
        {
            try
            {
                string query = $"Update ProcessContentPack set FK_Id_State = 2, Date_fin = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' where FK_Id_ContentPack = {id_pack} and FK_Id_Station = 412";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = $"UPDATE OrderLocal set Date_Fin = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' FROM DetailContentPackOrderLocal D JOIN OrderLocal O ON D.FK_Id_OrderLocal = O.Id_OrderLocal WHERE D.FK_Id_ContentPack = {id_pack}";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = $"UPDATE dbo.[Order] SET Date_Delivery = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' FROM ContentPack C join dbo.[Order] O on C.FK_Id_Order = O.Id_Order WHERE C.Id_ContentPack = {id_pack}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"Cập nhật thông tin của ProcessContentPack bị lỗi tại gói hàng {id_pack}: {e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateProcessSimpleAndOrder(int id_pack)
        {
            getIdContentSimple(id_pack);
            try
            {
                foreach (var id_simple in id_content_simple)
                {
                    string query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_fin = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' where FK_Id_ContentSimple = {id_simple} and FK_Id_Station = 412";
                    DataProvider.Instance.ExecuteNonQuery(query);

                    query = $"UPDATE OrderLocal set Date_Fin = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' FROM DetailContentSimpleOrderLocal D JOIN OrderLocal O ON D.FK_Id_OrderLocal = O.Id_OrderLocal WHERE D.FK_Id_ContentSimple = {id_simple}";
                    DataProvider.Instance.ExecuteNonQuery(query);

                    query = $"UPDATE dbo.[Order] SET Date_Delivery = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' FROM ContentSimple C join dbo.[Order] O on C.FK_Id_Order = O.Id_Order WHERE C.Id_ContentSimple = {id_simple}";
                    DataProvider.Instance.ExecuteNonQuery(query);
                }
            }
            catch (SqlException e)
            {
                MessageBox.Show($"Cập nhật thông tin của ProcessContentSimple bị lỗi: {e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
