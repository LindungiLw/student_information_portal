import Image from "next/image";
import Link from "next/link";

export default function AuthLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <div className="flex min-h-screen w-full bg-[#F5F7FB]">
      {/* Left Pane (Image) */}
      <div className="hidden lg:flex w-1/2 relative bg-theme-blue-300">
        <Image
          src="/image.png"
          alt="Campus Background"
          fill sizes="100vw"
          className="object-cover object-center mix-blend-overlay opacity-60"
          priority
        />
        <div className="absolute inset-0 bg-[#3B4283]/85 z-0 mix-blend-multiply" />
        <div className="absolute inset-0 bg-[#233374]/60 z-0" />
        
        <div className="relative z-10 flex flex-col justify-end p-16 text-white h-full pb-28">
          <p className="text-sm tracking-widest font-semibold mb-4 opacity-90 uppercase">
            Jakarta International University
          </p>
          <h1 className="text-5xl lg:text-6xl font-bold mb-6 leading-[1.1] max-w-xl tracking-tight drop-shadow-md">
            The journey to <br />excellence<br /> begins here.
          </h1>
          <p className="text-lg opacity-80 max-w-md font-medium leading-relaxed drop-shadow">
            Access your academic record, course<br />registration, and campus resources through the<br />Scholar Core unified portal.
          </p>
        </div>
      </div>

      {/* Right Pane (Form Container) */}
      <div className="flex-1 flex flex-col items-center justify-center p-8 relative">
        {/* Top Logo */}
        <div className="absolute top-12 lg:top-16 flex items-center gap-3 text-theme-blue-300">
          <div className="bg-theme-blue-300 p-2 rounded-lg flex items-center justify-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
              <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
          </div>
          <span className="font-bold text-xl tracking-tight">Student Information Portal</span>
        </div>

        {/* Form Content */}
        <div className="w-full max-w-[420px] mt-16">
          {children}
        </div>

        {/* Footer */}
        <div className="absolute bottom-8 lg:bottom-12 flex gap-8 text-[11px] font-bold text-zinc-400 tracking-widest uppercase">
          <Link href="#" className="hover:text-zinc-600 transition-colors">Help</Link>
          <Link href="#" className="hover:text-zinc-600 transition-colors">Privacy</Link>
          <Link href="#" className="hover:text-zinc-600 transition-colors">Accessibility</Link>
        </div>
      </div>
    </div>
  );
}
