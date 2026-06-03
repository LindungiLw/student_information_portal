import Image from "next/image";
import Link from "next/link";
import { Calendar as CalendarIcon, ChevronRight } from "lucide-react";

export default function UpcomingEventsPage() {
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
        <Link href="/dashboard/calendar" className="text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">
          Academic Calendar
        </Link>
        <ChevronRight size={16} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-900">Upcoming Events</span>
      </div>

      {/* Main Content */}
      <div className="bg-white border border-gray-100 rounded-3xl p-8 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] w-full mb-10">
        <h2 className="text-lg font-bold text-gray-900 mb-8">Upcoming Events</h2>
        
        <div className="flex flex-col gap-6">
          
          <div className="flex items-start gap-5">
            <div className="flex flex-col items-center justify-center w-14 h-14 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
              <span className="text-[10px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Mar</span>
              <span className="text-[17px] font-bold text-theme-purple-400 leading-none">14</span>
            </div>
            <div className="flex flex-col pt-1">
              <h4 className="text-sm font-bold text-gray-900">AI Ethics Seminar</h4>
              <p className="text-xs text-gray-500 font-medium mt-1">2:00 PM • Hall A</p>
            </div>
          </div>

          <div className="w-full h-px bg-gray-100 my-1"></div>

          <div className="flex items-start gap-5">
            <div className="flex flex-col items-center justify-center w-14 h-14 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
              <span className="text-[10px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Mar</span>
              <span className="text-[17px] font-bold text-theme-purple-400 leading-none">18</span>
            </div>
            <div className="flex flex-col pt-1">
              <h4 className="text-sm font-bold text-gray-900">Career Fair 2023</h4>
              <p className="text-xs text-gray-500 font-medium mt-1">10:00 AM • Plaza</p>
            </div>
          </div>
          
          <div className="w-full h-px bg-gray-100 my-1"></div>

          <div className="flex items-start gap-5">
            <div className="flex flex-col items-center justify-center w-14 h-14 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
              <span className="text-[10px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Mar</span>
              <span className="text-[17px] font-bold text-theme-purple-400 leading-none">25</span>
            </div>
            <div className="flex flex-col pt-1">
              <h4 className="text-sm font-bold text-gray-900">HackerThon Kickoff</h4>
              <p className="text-xs text-gray-500 font-medium mt-1">6:30 PM • Lab 404</p>
            </div>
          </div>

          <div className="w-full h-px bg-gray-100 my-1"></div>

          <div className="flex items-start gap-5">
            <div className="flex flex-col items-center justify-center w-14 h-14 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
              <span className="text-[10px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Mar</span>
              <span className="text-[17px] font-bold text-theme-purple-400 leading-none">25</span>
            </div>
            <div className="flex flex-col pt-1">
              <h4 className="text-sm font-bold text-gray-900">Career Fair</h4>
              <p className="text-xs text-gray-500 font-medium mt-1">10:00 AM • Student Center</p>
            </div>
          </div>

          <div className="w-full h-px bg-gray-100 my-1"></div>

          <div className="flex items-start gap-5">
            <div className="flex flex-col items-center justify-center w-14 h-14 bg-theme-purple-100/20 rounded-xl border border-theme-purple-100/30 text-center flex-shrink-0">
              <span className="text-[10px] font-bold text-theme-purple-400 uppercase leading-none mb-1">Mar</span>
              <span className="text-[17px] font-bold text-theme-purple-400 leading-none">31</span>
            </div>
            <div className="flex flex-col pt-1">
              <h4 className="text-sm font-bold text-gray-900">Halloween Mixer</h4>
              <p className="text-xs text-gray-500 font-medium mt-1">07:00 PM • Main Quad</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  );
}
