import Image from "next/image";
import { Link2, Mail, BookOpen, Monitor, FileText, Megaphone, Calendar as CalendarIcon, Users, GraduationCap } from "lucide-react";

export default function Dashboard() {
  return (
    <div className="max-w-[960px] mx-auto w-full flex flex-col gap-10">
      
      {/* Hero Section */}
      <div className="relative w-full h-[220px] rounded-[20px] overflow-hidden shadow-sm">
        <Image
          src="/image.png"
          alt="Campus Banner"
          fill
          className="object-cover object-center"
          priority
        />
        <div className="absolute inset-0 bg-black/40 z-0"></div>
        <div className="absolute inset-0 flex flex-col justify-end p-10 z-10 text-white">
          <h1 className="text-4xl font-bold mb-2 tracking-tight">Welcome back, User!</h1>
          <p className="text-white/90 font-medium">Access Your academic life, simplified.</p>
        </div>
      </div>

      {/* Intro Text */}
      <div className="text-center px-8 md:px-16">
        <p className="text-[#64748B] font-medium leading-relaxed text-[15px]">
          Welcome to the Student Information Portal. This is your central hub for essential school resources. Use this site to access your <span className="font-bold text-gray-800">curriculum</span>, academic policies, and dormitory regulations, or to explore our diverse academic programs.
        </p>
      </div>

      {/* Main Grid Content */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
        
        {/* Left Column (Stats + Announcements) */}
        <div className="lg:col-span-2 flex flex-col gap-8">
          
          {/* Stats Cards */}
          <div className="grid grid-cols-2 gap-5">
            <div className="bg-white border border-gray-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)]">
              <Users className="text-theme-blue-100 mb-3" size={24} />
              <div className="text-xs font-semibold text-gray-500 mb-1">Students</div>
              <div className="text-xl font-bold text-gray-900">-</div>
            </div>
            <div className="bg-white border border-gray-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)]">
              <GraduationCap className="text-theme-blue-100 mb-3" size={24} />
              <div className="text-xs font-semibold text-gray-500 mb-1">Lecturers</div>
              <div className="text-xl font-bold text-gray-900">-</div>
            </div>
          </div>

          {/* Announcements */}
          <div>
            <div className="flex items-center justify-between mb-4 px-1">
              <h2 className="text-[17px] font-bold text-gray-900 flex items-center gap-2">
                <Megaphone size={20} className="text-gray-900" />
                Recent Announcements
              </h2>
              <a href="#" className="text-xs font-bold text-theme-purple-400 hover:underline">View all</a>
            </div>
            <div className="bg-white border border-gray-100 rounded-2xl p-6 flex flex-col gap-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)]">
              
              <div className="flex flex-col gap-2 border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                <h3 className="font-bold text-gray-900 text-[15px]">Fall 2024 Registration Guidelines</h3>
                <p className="text-[13px] text-gray-500 leading-relaxed pr-4">
                  Registration for the Fall 2024 semester begins next Monday. Please review your degree audit and consult with your advisor before selecting...
                </p>
                <div className="flex items-center gap-3 text-[11px] font-medium text-gray-400 mt-2">
                  <span className="flex items-center gap-1.5"><CalendarIcon size={12} /> Oct 24, 2023</span>
                  <span className="w-1 h-1 rounded-full bg-gray-300"></span>
                  <span>Academic Affairs</span>
                </div>
              </div>

              <div className="flex flex-col gap-2 border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                <h3 className="font-bold text-gray-900 text-[15px]">Library Hours Extended for Finals</h3>
                <p className="text-[13px] text-gray-500 leading-relaxed pr-4">
                  The main library will be open 24/7 starting December 1st to support students during finals week. Study rooms can be booked online.
                </p>
                <div className="flex items-center gap-3 text-[11px] font-medium text-gray-400 mt-2">
                  <span className="flex items-center gap-1.5"><CalendarIcon size={12} /> Oct 22, 2023</span>
                  <span className="w-1 h-1 rounded-full bg-gray-300"></span>
                  <span>Library Services</span>
                </div>
              </div>

            </div>
          </div>
        </div>

        {/* Right Column (Quick Links + Upcoming) */}
        <div className="flex flex-col gap-8">
          
          {/* Quick Links */}
          <div>
            <h2 className="text-[17px] font-bold text-gray-900 flex items-center gap-2 mb-4 px-1">
              <Link2 size={20} className="text-theme-purple-400" />
              Quick Links
            </h2>
            <div className="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)]">
              <div className="grid grid-cols-2 gap-3">
                <a href="#" className="flex flex-col items-center justify-center gap-2.5 p-4 bg-[#F8F9FB] rounded-xl hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-900">
                  <Mail size={22} className="text-gray-400" />
                  <span className="text-[11px] font-bold">Webmail</span>
                </a>
                <a href="#" className="flex flex-col items-center justify-center gap-2.5 p-4 bg-[#F8F9FB] rounded-xl hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-900">
                  <BookOpen size={22} className="text-gray-400" />
                  <span className="text-[11px] font-bold">Library</span>
                </a>
                <a href="#" className="flex flex-col items-center justify-center gap-2.5 p-4 bg-[#F8F9FB] rounded-xl hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-900">
                  <Monitor size={22} className="text-gray-400" />
                  <span className="text-[11px] font-bold">Website</span>
                </a>
                <a href="#" className="flex flex-col items-center justify-center gap-2.5 p-4 bg-[#F8F9FB] rounded-xl hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-900">
                  <FileText size={22} className="text-gray-400" />
                  <span className="text-[11px] font-bold">SIAKAD</span>
                </a>
              </div>
            </div>
          </div>

          {/* Upcoming */}
          <div>
            <h2 className="text-[17px] font-bold text-gray-900 flex items-center gap-2 mb-4 px-1">
              <CalendarIcon size={20} className="text-theme-purple-400" />
              Upcoming
            </h2>
            <div className="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-4 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)]">
              
              <div className="flex items-center gap-4">
                <div className="flex flex-col items-center justify-center w-12 h-12 bg-[#F8F9FB] rounded-lg border border-gray-100 text-center flex-shrink-0">
                  <span className="text-[9px] font-bold text-red-500 uppercase leading-none mb-1">Mar</span>
                  <span className="text-sm font-bold text-gray-900 leading-none">25</span>
                </div>
                <div className="flex flex-col gap-0.5">
                  <h4 className="text-[13px] font-bold text-gray-900">Career Fair</h4>
                  <p className="text-[10px] text-gray-500 font-medium">10:00 AM • Student Center</p>
                </div>
              </div>

              <div className="w-full h-px bg-gray-100"></div>

              <div className="flex items-center gap-4">
                <div className="flex flex-col items-center justify-center w-12 h-12 bg-[#F8F9FB] rounded-lg border border-gray-100 text-center flex-shrink-0">
                  <span className="text-[9px] font-bold text-red-500 uppercase leading-none mb-1">Mar</span>
                  <span className="text-sm font-bold text-gray-900 leading-none">31</span>
                </div>
                <div className="flex flex-col gap-0.5">
                  <h4 className="text-[13px] font-bold text-gray-900">Halloween Mixer</h4>
                  <p className="text-[10px] text-gray-500 font-medium">07:00 PM • Main Quad</p>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  );
}
