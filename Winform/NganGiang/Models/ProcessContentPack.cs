using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class ProcessContentPack
    {
        public double FK_Id_ContentPack { get; set; }
        public int FK_Id_Station { get; set; }
        public int FK_Id_State { get; set; }
        public DateTime Data_Start { get; set; }
        public DateTime Data_Fin { get; set; }
    }
}
