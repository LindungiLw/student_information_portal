import Image from "next/image";
import Link from "next/link";

export default function Home() {
  return (
    <div className="relative min-h-screen w-full flex flex-col justify-between overflow-hidden">
      {/* Background Image */}
      <div className="absolute inset-0 z-[-2]">
        <Image 
          src="/image.png" 
          alt="Campus Background" 
          fill 
          className="object-cover object-center"
          priority
        />
      </div>
      
      {/* Dark Overlay */}
      <div className="absolute inset-0 bg-black/60 z-[-1]"></div>

      {/* Header */}
      <header className="w-full p-8 md:p-12 flex items-center">
        {/* Logo */}
        <div className="flex items-center gap-3 text-white select-none">
          <div className="font-bold text-4xl tracking-tighter">JIU</div>
          <div className="h-10 w-px bg-white/50"></div>
          <div className="text-[10px] leading-tight font-semibold tracking-widest">
            JAKARTA<br/>
            INTERNATIONAL<br/>
            UNIVERSITY
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="flex-1 flex flex-col items-center justify-center px-6 text-center mt-[-80px]">
        <h1 className="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 tracking-tight drop-shadow-lg">
          Your Academic Life, <span className="text-theme-yellow-300">Simplified</span>
        </h1>
        <p className="max-w-2xl text-white/90 text-sm md:text-base font-medium mb-12 drop-shadow-md">
          Access all academic information, student activities, and campus services<br className="hidden md:block" /> within a single integrated platform.
        </p>

        {/* Buttons */}
        <div className="flex flex-wrap items-center justify-center gap-5">
          <Link href="/sign-in" className="px-12 py-3 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 text-white font-semibold transition-all hover:bg-white/30 shadow-lg">
            Sign In
          </Link>
          <Link href="/sign-up" className="px-12 py-3 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 text-white font-semibold transition-all hover:bg-white/30 shadow-lg">
            Sign Up
          </Link>
        </div>
      </main>

      {/* Footer */}
      <footer className="w-full text-center py-8 text-white/60 text-xs">
        <div className="max-w-7xl mx-auto px-6 border-t border-white/20 pt-8">
          &copy; 2023 Student Information Portal. All rights reserved.
        </div>
      </footer>
    </div>
  );
}
