using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class ProcessContentSimple
    {
        public decimal FK_Id_ContentSimple { get; set; }
        public int FK_Id_Station { get; set; }
        public short FK_Id_State { get; set; }
        public string? Data_Start { get; set; }
        public string? Data_Fin { get; set; }
    }
}
