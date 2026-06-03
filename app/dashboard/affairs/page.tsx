import Image from "next/image";
import Link from "next/link";
import { Users, ShieldCheck } from "lucide-react";

export default function StudentAffairsPage() {
  return (
    <div className="max-w-[1000px] mx-auto w-full flex flex-col gap-8 pb-10">
      
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
      <div className="w-full bg-[#E5E7EB] rounded-xl py-3.5 px-5 flex items-center gap-3 text-gray-500 shadow-sm border border-gray-100">
        <Users size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">Student Affairs</span>
      </div>

      {/* Student Union Leadership */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-2 text-theme-purple-400">
            <ShieldCheck size={18} />
            <h2 className="text-sm font-bold text-gray-900">Student Union Leadership</h2>
          </div>
          <Link href="#" className="text-xs font-bold text-theme-purple-400 hover:underline">
            See more
          </Link>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          
          {/* President Card */}
          <div className="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-5 items-start">
            <div className="w-24 h-24 rounded-2xl bg-gray-200 overflow-hidden relative flex-shrink-0">
              <Image src="/image.png" alt="President" fill sizes="100vw" className="object-cover" />
            </div>
            <div className="flex flex-col flex-1">
              <span className="px-2 py-0.5 bg-[#F4EDFC] text-theme-purple-400 text-[9px] font-bold uppercase tracking-widest rounded mb-2 self-start">President</span>
              <h3 className="font-bold text-gray-900 text-lg mb-2">President</h3>
              <p className="text-[11px] text-gray-500 italic mb-4 leading-relaxed">"Empowering every student voice for a better tomorrow."</p>
              <a href="mailto:president@jiu.ac" className="text-[10px] text-gray-400 hover:text-theme-purple-400 transition-colors mt-auto">president@jiu.ac</a>
            </div>
          </div>
          
          {/* Vice President Card */}
          <div className="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-5 items-start">
            <div className="w-24 h-24 rounded-2xl bg-gray-200 overflow-hidden relative flex-shrink-0">
              <Image src="/image.png" alt="Vice President" fill sizes="100vw" className="object-cover" />
            </div>
            <div className="flex flex-col flex-1">
              <span className="px-2 py-0.5 bg-[#F4EDFC] text-theme-purple-400 text-[9px] font-bold uppercase tracking-widest rounded mb-2 self-start">Vice President</span>
              <h3 className="font-bold text-gray-900 text-lg mb-2">Vice</h3>
              <p className="text-[11px] text-gray-500 italic mb-4 leading-relaxed">"Building a vibrant and inclusive campus community."</p>
              <a href="mailto:vice@jiu.ac" className="text-[10px] text-gray-400 hover:text-theme-purple-400 transition-colors mt-auto">vice@jiu.ac</a>
            </div>
          </div>

        </div>
      </div>

      {/* Club Activities */}
      <div className="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col gap-6">
        <div className="flex flex-col gap-1">
          <h2 className="text-sm font-bold text-gray-900">Club Activities</h2>
          <p className="text-[11px] text-gray-500">Explore your passions! A wide variety of student clubs are waiting for you.</p>
        </div>
        
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          
          <div className="relative h-[160px] rounded-2xl overflow-hidden shadow-sm group cursor-pointer">
            <Image src="/image.png" alt="Sports" fill sizes="100vw" className="object-cover transition-transform duration-500 group-hover:scale-110" />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div className="absolute bottom-0 left-0 p-4 flex flex-col text-white">
              <h4 className="font-bold text-sm">Sports</h4>
              <span className="text-[9px] text-white/70">12 Active Clubs</span>
            </div>
          </div>
          
          <div className="relative h-[160px] rounded-2xl overflow-hidden shadow-sm group cursor-pointer">
            <Image src="/image.png" alt="Arts" fill sizes="100vw" className="object-cover transition-transform duration-500 group-hover:scale-110" />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div className="absolute bottom-0 left-0 p-4 flex flex-col text-white">
              <h4 className="font-bold text-sm">Arts</h4>
              <span className="text-[9px] text-white/70">8 Active Clubs</span>
            </div>
          </div>
          
          <div className="relative h-[160px] rounded-2xl overflow-hidden shadow-sm group cursor-pointer">
            <Image src="/image.png" alt="Technology" fill sizes="100vw" className="object-cover transition-transform duration-500 group-hover:scale-110" />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div className="absolute bottom-0 left-0 p-4 flex flex-col text-white">
              <h4 className="font-bold text-sm">Technology</h4>
              <span className="text-[9px] text-white/70">15 Active Clubs</span>
            </div>
          </div>
          
          <div className="relative h-[160px] rounded-2xl overflow-hidden shadow-sm group cursor-pointer">
            <Image src="/image.png" alt="Community" fill sizes="100vw" className="object-cover transition-transform duration-500 group-hover:scale-110" />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div className="absolute bottom-0 left-0 p-4 flex flex-col text-white">
              <h4 className="font-bold text-sm">Community</h4>
              <span className="text-[9px] text-white/70">10 Active Clubs</span>
            </div>
          </div>
          
        </div>
      </div>

    </div>
  );
}
