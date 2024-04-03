using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class DetailStateCellOfPackWareHouse : IComparable<DetailStateCellOfPackWareHouse>
    {
        public int Rowi { get; set; }
        public int Colj { get; set; }
        public short FK_Id_StateCell { get; set; }
        public int FK_Id_Station { get; set; }
        public decimal FK_Id_ContentPack { get; set; }
        public int Count_Container { get; set; }
        public int CompareTo(DetailStateCellOfPackWareHouse other)
        {
            int compareResult = Rowi.CompareTo(other.Rowi);

            if (compareResult == 0)
            {
                compareResult = Colj.CompareTo(other.Colj);
            }

            return compareResult;
        }
    }
}
