import Image from "next/image";
import Link from "next/link";
import { Calendar as CalendarIcon, ChevronRight } from "lucide-react";
import CalendarWidget from "@/components/CalendarWidget";

export default function CalendarPage() {
  return (
    <div className="max-w-[1000px] mx-auto w-full flex flex-col gap-8">
      
      {/* Hero Section */}
      <div className="relative w-full h-[200px] rounded-[20px] overflow-hidden shadow-sm">
        <Image
          src="/image.png"
          alt="Campus Banner"
          fill sizes="100vw"
          className="object-cover object-center"
          priority
        />
        <div className="absolute inset-0 bg-black/40 z-0"></div>
        <div className="absolute inset-0 flex flex-col justify-end p-8 z-10 text-white">
          <h1 className="text-4xl font-bold mb-2 tracking-tight">Welcome back, User!</h1>
          <p className="text-white/90 font-medium">Access Your academic life, simplified.</p>
        </div>
      </div>

      {/* Breadcrumb Bar */}
      <div className="w-full bg-[#F3F4F6] rounded-xl py-3.5 px-5 flex items-center gap-3 text-gray-500 shadow-sm border border-gray-100">
        <CalendarIcon size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">Academic Calendar</span>
        <ChevronRight size={16} className="text-gray-400" />
      </div>

      {/* Main Grid Content */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-10">
        
        {/* Left Column (Mini Calendar) */}
        <div className="lg:col-span-4 flex flex-col">
          <CalendarWidget />
        </div>

        {/* Middle Column (Upcoming Events) */}
        <div className="lg:col-span-5 flex flex-col">
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] w-full h-full">
            <div className="flex items-center justify-between mb-6">
              <h2 className="text-base font-bold text-gray-900">Upcoming Events</h2>
              <Link href="/dashboard/calendar/upcoming-events" className="text-xs font-bold text-theme-purple-400 hover:underline">
                View All
              </Link>
            </div>
            
            <div className="flex flex-col gap-5">
              
              <div className="flex items-start gap-4">
                <div className="flex flex-col items-center justify-center w-12 h-12 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
                  <span className="text-[9px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Oct</span>
                  <span className="text-[15px] font-bold text-theme-purple-400 leading-none">14</span>
                </div>
                <div className="flex flex-col pt-0.5">
                  <h4 className="text-sm font-bold text-gray-900">AI Ethics Seminar</h4>
                  <p className="text-[11px] text-gray-500 font-medium mt-0.5">2:00 PM • Hall A</p>
                </div>
              </div>

              <div className="flex items-start gap-4">
                <div className="flex flex-col items-center justify-center w-12 h-12 bg-theme-blue-100/20 rounded-xl border border-theme-blue-100/30 text-center flex-shrink-0">
                  <span className="text-[9px] font-bold text-theme-blue-300 uppercase leading-none mb-1">Oct</span>
                  <span className="text-[15px] font-bold text-theme-blue-300 leading-none">18</span>
                </div>
                <div className="flex flex-col pt-0.5">
                  <h4 className="text-sm font-bold text-gray-900">Career Fair 2023</h4>
                  <p className="text-[11px] text-gray-500 font-medium mt-0.5">10:00 AM • Plaza</p>
                </div>
              </div>
              
              <div className="flex items-start gap-4">
                <div className="flex flex-col items-center justify-center w-12 h-12 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
                  <span className="text-[9px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Oct</span>
                  <span className="text-[15px] font-bold text-theme-purple-400 leading-none">25</span>
                </div>
                <div className="flex flex-col pt-0.5">
                  <h4 className="text-sm font-bold text-gray-900">HackerThon Kickoff</h4>
                  <p className="text-[11px] text-gray-500 font-medium mt-0.5">6:30 PM • Lab 404</p>
                </div>
              </div>

            </div>
          </div>
        </div>

        {/* Right Column (Color Guide) */}
        <div className="lg:col-span-3 flex flex-col">
          <div className="bg-[#F8F9FB] border border-dashed border-gray-300 rounded-3xl p-6 shadow-sm w-full">
            <h3 className="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-5">Color Guide</h3>
            
            <div className="flex flex-col gap-3.5">
              <div className="flex items-center gap-3 text-xs font-semibold text-gray-700">
                <div className="w-2.5 h-2.5 rounded-full bg-theme-purple-400"></div>
                Exams
              </div>
              <div className="flex items-center gap-3 text-xs font-semibold text-gray-700">
                <div className="w-2.5 h-2.5 rounded-full bg-theme-yellow-400"></div>
                University Announcements
              </div>
              <div className="flex items-center gap-3 text-xs font-semibold text-gray-700">
                <div className="w-2.5 h-2.5 rounded-full bg-theme-blue-300"></div>
                University Events
              </div>
              <div className="flex items-center gap-3 text-xs font-semibold text-gray-700">
                <div className="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                Holiday
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  );
}
