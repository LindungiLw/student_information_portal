"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { 
  Home, 
  Calendar, 
  GraduationCap, 
  Building, 
  CreditCard, 
  Users, 
  Globe, 
  Headphones, 
  Settings 
} from "lucide-react";

export default function DashboardLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const pathname = usePathname();

  const getLinkClass = (path: string) => {
    const isActive = pathname === path;
    return `flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium text-[13px] transition-colors ${
      isActive 
        ? "bg-theme-blue-200 text-white shadow-inner" 
        : "text-white/80 hover:bg-white/10 hover:text-white"
    }`;
  };

  return (
    <div className="flex h-screen w-full overflow-hidden bg-[#E5E7EB] p-4 md:p-6 font-sans">
      <div className="flex h-full w-full bg-white rounded-[32px] overflow-hidden shadow-2xl border border-gray-200">
        
        {/* Sidebar */}
        <aside className="w-[280px] bg-theme-blue-100 flex flex-col text-white m-3 rounded-[24px] shadow-lg flex-shrink-0">
          {/* Logo Area */}
          <div className="p-8 flex items-center gap-4">
            <div className="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center font-bold text-xs tracking-tighter flex-shrink-0">
              JIU
            </div>
            <span className="font-bold text-[15px]">Student Portal</span>
          </div>
          
          <div className="px-8 mb-6">
            <div className="w-full h-px bg-white/10"></div>
          </div>

          {/* Navigation */}
          <nav className="flex-1 px-5 overflow-y-auto custom-scrollbar flex flex-col gap-8 pb-8">
            
            <div className="flex flex-col gap-1">
              <Link href="/dashboard" className={getLinkClass("/dashboard")}>
                <Home size={18} />
                Dashboard
              </Link>
            </div>

            <div className="flex flex-col gap-1.5">
              <div className="px-4 text-[10px] font-bold text-white/50 tracking-widest uppercase mb-1">Academics</div>
              <Link href="/dashboard/calendar" className={getLinkClass("/dashboard/calendar")}>
                <Calendar size={18} />
                Calendar
              </Link>
              <Link href="/dashboard/academics" className={getLinkClass("/dashboard/academics")}>
                <GraduationCap size={18} />
                Academics
              </Link>
              <Link href="/dashboard/department" className={getLinkClass("/dashboard/department")}>
                <Building size={18} />
                Department
              </Link>
            </div>

            <div className="flex flex-col gap-1.5">
              <div className="px-4 text-[10px] font-bold text-white/50 tracking-widest uppercase mb-1">Finance</div>
              <Link href="/dashboard/finance" className={getLinkClass("/dashboard/finance")}>
                <CreditCard size={18} />
                Cost of Attendance
              </Link>
            </div>

            <div className="flex flex-col gap-1.5">
              <div className="px-4 text-[10px] font-bold text-white/50 tracking-widest uppercase mb-1">Campus Life</div>
              <Link href="/dashboard/affairs" className={getLinkClass("/dashboard/affairs")}>
                <Users size={18} />
                Student Affairs
              </Link>
              <Link href="/dashboard/activities" className={getLinkClass("/dashboard/activities")}>
                <Globe size={18} />
                External Activities
              </Link>
              <Link href="#" className={getLinkClass("/dashboard/services")}>
                <Headphones size={18} />
                Student Services
              </Link>
            </div>
          </nav>

          {/* Bottom Area */}
          <div className="p-5 mt-auto">
            <Link href="#" className={getLinkClass("/dashboard/settings")}>
              <Settings size={18} />
              Settings
            </Link>
            <div className="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-colors cursor-pointer group">
              <div className="w-9 h-9 rounded-full bg-[#8E5AEC] flex items-center justify-center font-bold text-xs shadow-md">
                JS
              </div>
              <div className="flex flex-col">
                <span className="text-[13px] font-semibold group-hover:text-white transition-colors">John Student</span>
                <span className="text-[10px] text-white/60">ID: 2023001</span>
              </div>
            </div>
          </div>
        </aside>

        {/* Main Content Area */}
        <main className="flex-1 p-8 md:p-12 overflow-y-auto">
          {children}
        </main>
      </div>
    </div>
  );
}

