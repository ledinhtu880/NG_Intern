using NganGiang.Libs;
using NganGiang.Models;
using Org.BouncyCastle.Math.Field;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static Org.BouncyCastle.Math.EC.ECCurve;

namespace NganGiang.Services.Process
{
    internal class ProcessService410
    {
        public DataTable getProcessAt410()
        {
            string query = $"SELECT DISTINCT DCPOL.FK_Id_OrderLocal AS [Mã đơn hàng], PCP.FK_Id_ContentPack AS [Mã gói hàng], " +
                $"S.Name_State AS [Trạng thái], FORMAT(OL.Date_Start, 'dd-MM-yyyy') AS [Ngày bắt đầu] " +
                $"FROM ProcessContentPack PCP " +
                $"INNER JOIN DetailContentPackOrderLocal DCPOL ON PCP.FK_Id_ContentPack = DCPOL.FK_Id_ContentPack " +
                $"INNER JOIN [State] S ON S.Id_State = PCP.FK_Id_State " +
                $"INNER JOIN OrderLocal OL ON OL.Id_OrderLocal = DCPOL.FK_Id_OrderLocal " +
                $"WHERE PCP.FK_Id_Station = 410 AND PCP.FK_Id_State = 0 AND OL.Date_Fin IS NULL AND OL.MakeOrPackOrExpedition = 2 " +
                $"ORDER BY DCPOL.FK_Id_OrderLocal, PCP.FK_Id_ContentPack, S.Name_State, FORMAT(OL.Date_Start, 'dd-MM-yyyy')";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }

        public DataTable getInforContentSimpleByContentPack(ContentPack contentPack)
        {
            return Helper.getInforContentSimpleByContentPack(contentPack);
        }

        private bool updateContentPack(ContentPack contentPack, out string message)
        {
            message = "";
            contentPack.HaveEilmPE = true;
            string query = $"UPDATE ContentPack SET HaveEilmPE = '{contentPack.HaveEilmPE}' WHERE Id_ContentPack = {contentPack.Id_ContentPack}";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Cập nhật ContentPack thất bại";
                return false;
            }
            return true;
        }
        private int getTotalCountInRegister(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            string query = $"SELECT SUM(COUNT) as SoLuong FROM RegisterContentPackAtWareHouse " +
                $"WHERE FK_Id_ContentPack = {processContentPack.FK_Id_ContentPack}";
            DataTable result = DataProvider.Instance.ExecuteQuery(query);

            if (result.Rows[0]["SoLuong"] != DBNull.Value)
            {
                int totalCount = Convert.ToInt32(result.Rows[0]["SoLuong"]);
                return totalCount;
            }
            else
            {
                return -1; // Hoặc giá trị tùy ý để chỉ ra rằng kết quả truy vấn là NULL
            }
        }
        private int getTotalCountInWareHouse(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            string query = $"select Count_Pack from ContentPack where Id_ContentPack = {processContentPack.FK_Id_ContentPack}";
            DataTable result = DataProvider.Instance.ExecuteQuery(query);

            if (result.Rows[0]["Count_Pack"] != DBNull.Value)
            {
                // Lấy giá trị trạm tiếp theo từ kết quả
                int totalCount = Convert.ToInt32(result.Rows[0]["Count_Pack"]);
                return totalCount;
            }
            else
            {
                // Không có kết quả trả về
                return -1;
            }
        }
        private bool updateProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            return Helper.updateProcessContentPack(processContentPack, out message);
        }
        private bool createProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            processContentPack.FK_Id_Station = 411;
            return Helper.createProcessContentPack(processContentPack, out message);
        }
        private bool createProcessContentSimple(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            List<decimal> listIdContentSimples = Helper.getIdContentSimple(processContentPack, out message);

            foreach (decimal IdContentSimple in listIdContentSimples)
            {
                ProcessContentSimple processContentSimple = new ProcessContentSimple();
                processContentSimple.FK_Id_ContentSimple = IdContentSimple;
                processContentSimple.FK_Id_State = 0;
                processContentSimple.FK_Id_Station = 411;
                processContentSimple.Date_Start = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"INSERT INTO ProcessContentSimple(FK_Id_ContentSimple, FK_Id_State, FK_Id_Station, Date_Start) VALUES({processContentSimple.FK_Id_ContentSimple}, {processContentSimple.FK_Id_State}, {processContentSimple.FK_Id_Station}, '{processContentSimple.Date_Start}')";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Tạo ProcessContentSimple thất bại, Lỗi khi tạo FK_Id_ContentSimple";
                    return false;
                }
            }
            return true;
        }
        private bool updateProcessContentSimple(ProcessContentPack processContentPack, out string message)
        {
            List<decimal> listIdContentSimples = Helper.getIdContentSimple(processContentPack, out message);
            foreach (decimal IdContentSimple in listIdContentSimples)
            {
                ProcessContentSimple processContentSimple = new ProcessContentSimple();
                processContentSimple.FK_Id_ContentSimple = IdContentSimple;
                processContentSimple.FK_Id_State = 2;
                processContentSimple.FK_Id_Station = 410;
                processContentSimple.Date_Fin = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"UPDATE ProcessContentSimple SET FK_Id_State = {processContentSimple.FK_Id_State}, Date_Fin = '{processContentSimple.Date_Fin}' WHERE FK_Id_ContentSimple = {processContentSimple.FK_Id_ContentSimple} AND FK_Id_Station = {processContentSimple.FK_Id_Station}";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Cập nhật ProcessContentSimple thất bại tại thùng hàng số " + IdContentSimple;
                    return false;
                }
            }
            return true;
        }
        public int checkCustomer(ProcessContentPack processContentPack)
        {
            try
            {
                string query = $"SELECT CustomerType.ID " +
                    $"FROM ContentPack " +
                    $"JOIN [Order] ON ContentPack.FK_Id_Order = [Order].Id_Order " +
                    $"JOIN Customer ON [Order].FK_Id_Customer = Customer.Id_Customer " +
                    $"JOIN CustomerType ON Customer.FK_Id_CustomerType = CustomerType.Id " +
                    $"WHERE ContentPack.Id_ContentPack = {processContentPack.FK_Id_ContentPack}";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows.Count > 0 && result.Rows[0]["ID"] != DBNull.Value)
                {
                    int customerType = Convert.ToInt32(result.Rows[0]["ID"]);
                    return customerType;
                }
                else
                {
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy kiểu khách hàng.\n" + ex.Message);
                return -1;
            }
        }
        private bool updateDetailStateCellOfPackWareHouse(ContentPack contentPack, out string message)
        {
            message = "";
            ProcessContentPack processContentPack = new ProcessContentPack();
            processContentPack.FK_Id_ContentPack = contentPack.Id_ContentPack;
            if (this.checkCustomer(processContentPack) == 1)
            {
                if (this.getTotalCountInRegister(processContentPack, out message) != this.getTotalCountInWareHouse(processContentPack, out message))
                {
                    message = "Số lượng gói hàng trong kho vẫn còn dư";
                    return false;
                }
            }
            return true;
        }

        public int GetTotalCountInRegister(int id)
        {
            try
            {
                string query = $"SELECT SUM(COUNT) as SoLuong FROM RegisterContentSimpleAtWareHouse " +
                    $"WHERE FK_Id_ContentSimple IN " +
                    $"(SELECT DCS.FK_Id_ContentSimple FROM DetailContentSimpleOfPack DCS WHERE DCS.FK_Id_ContentPack = {id})";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows[0]["SoLuong"] != DBNull.Value)
                {
                    int totalCount = Convert.ToInt32(result.Rows[0]["SoLuong"]);
                    return totalCount;
                }
                else
                {
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy trạm tiếp theo.\n" + ex.Message);
                return -1;
            }
        }
        public int GetTotalCountInWarehouse(int id)
        {
            try
            {
                string query = $"Select SUM(Count_Container) as SoLuong from DetailStateCellOfSimpleWareHouse " +
                    $"inner join ContentSimple on Id_ContentSimple = FK_Id_ContentSimple " +
                    $"where FK_Id_ContentSimple in (SELECT DCS.FK_Id_ContentSimple FROM DetailContentSimpleOfPack DCS " +
                    $"WHERE DCS.FK_Id_ContentPack = ${id})";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows[0]["SoLuong"] != DBNull.Value)
                {
                    int totalCount = Convert.ToInt32(result.Rows[0]["SoLuong"]);
                    return totalCount;
                }
                else
                {
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy số lượng thùng chứa của gói hàng.\n" + ex.Message);
                return -1;
            }
        }
        public bool UpdateWarehouse(int id)
        {
            try
            {
                int totalCountInRegister = GetTotalCountInRegister(id);
                int totalCountInWarehouse = GetTotalCountInWarehouse(id);
                if (totalCountInRegister == totalCountInWarehouse)
                {
                    string query = $"UPDATE DetailStateCellOfSimpleWareHouse SET FK_Id_StateCell = 1, " +
                        $"FK_Id_ContentSimple = NULL WHERE FK_Id_ContentSimple IN " +
                        $"(SELECT DCS.FK_Id_ContentSimple FROM DetailContentSimpleOfPack DCS " +
                        $"WHERE DCS.FK_Id_ContentPack = {id})";
                    DataProvider.Instance.ExecuteNonQuery(query);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return false;
            }
        }

        public bool processAt410(ContentPack contentPack, out string message)
        {
            if (!this.updateContentPack(contentPack, out message))
            {
                return false;
            }
            if (!this.updateDetailStateCellOfPackWareHouse(contentPack, out message))
            {
                return false;
            }
            ProcessContentPack processContentPack = new ProcessContentPack();
            processContentPack.FK_Id_ContentPack = contentPack.Id_ContentPack;
            if (!this.updateProcessContentSimple(processContentPack, out message))
            {
                return false;
            }
            if (!this.updateProcessContentPack(processContentPack, out message))
            {
                return false;
            }
            if (!this.createProcessContentPack(processContentPack, out message))
            {
                return false;
            }
            if (!this.createProcessContentSimple(processContentPack, out message))
            {
                return false;
            }
            return true;
        }
    }
}
