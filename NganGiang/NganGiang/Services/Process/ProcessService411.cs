using NganGiang.Libs;
using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static Org.BouncyCastle.Math.EC.ECCurve;

namespace NganGiang.Services.Process
{
    internal class ProcessService411
    {
        public DataTable getProcessAt411()
        {
            string query = $"SELECT DCPOL.FK_Id_OrderLocal, \r\n\t PCP.FK_Id_ContentPack, S.Name_State, FORMAT(OL.Date_Start, 'dd-MM-yyyy') AS Date_Start\r\nFROM ProcessContentPack PCP\r\nINNER JOIN DetailContentPackOrderLocal DCPOL ON PCP.FK_Id_ContentPack = DCPOL.FK_Id_ContentPack\r\nINNER JOIN [State] S ON S.Id_State = PCP.FK_Id_State\r\nINNER JOIN OrderLocal OL ON OL.Id_OrderLocal = DCPOL.FK_Id_OrderLocal\r\nWHERE PCP.FK_Id_Station = 411 AND PCP.FK_Id_State = 0";
            DataTable tb = DataProvider.Instance.ExecuteQuery(query);
            return tb;
        }
        public DataTable getInforContentSimpleByContentPack(ContentPack contentPack)
        {
            return Helper.getInforContentSimpleByContentPack(contentPack);
        }
        private string generaterCodeNFC(string Id_ContentPack)
        {
            string codeNFC = "NFC-IDPC-";
            int len = Id_ContentPack.Length;
            for (int i = 0; i < 11 - len; i++)
            {
                codeNFC += "0";
            }
            codeNFC += Id_ContentPack;
            return codeNFC;
        }

        private bool updateContentPack(ContentPack contentPack, out string message)
        {

            contentPack.CodeNFC = this.generaterCodeNFC(contentPack.Id_ContentPack.ToString());
            contentPack.HaveNFC = true;
            message = "";
            string query = $"UPDATE ContentPack SET CodeNFC = '{contentPack.CodeNFC}', HaveNFC = '{contentPack.HaveNFC}' WHERE Id_ContentPack = {contentPack.Id_ContentPack}";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Cập nhật ContentPack thất bại";
                return false;
            }
            return true;

        }
        private bool updateProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            return Helper.updateProcessContentPack(processContentPack, out message);
        }
        private bool createProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            processContentPack.FK_Id_Station = 412;
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
                processContentSimple.FK_Id_Station = 412;
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
                processContentSimple.FK_Id_Station = 411;
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
        public bool processAt411(ContentPack contentPack, out string message)
        {
            if (!this.updateContentPack(contentPack, out message))
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
