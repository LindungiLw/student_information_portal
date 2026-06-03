import Link from "next/link";

export default function SignUp() {
  return (
    <div className="w-full">
      <h2 className="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Create Account</h2>
      <p className="text-gray-500 text-sm mb-10 font-medium">Make Sure You Are Register With Your JIU's Account</p>

      <form className="flex flex-col gap-6">
        <div className="flex flex-col gap-2">
          <label className="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Full Name</label>
          <input 
            type="text" 
            placeholder="John Doe" 
            className="w-full px-4 py-3.5 rounded-lg bg-[#F0F2F5] border-transparent focus:bg-white focus:border-theme-blue-300 focus:ring-2 focus:ring-theme-blue-300/20 outline-none transition-all placeholder:text-gray-400 font-medium text-gray-900"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label className="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Student ID Number</label>
          <input 
            type="text" 
            placeholder="SC-2024-XXXX" 
            className="w-full px-4 py-3.5 rounded-lg bg-[#F0F2F5] border-transparent focus:bg-white focus:border-theme-blue-300 focus:ring-2 focus:ring-theme-blue-300/20 outline-none transition-all placeholder:text-gray-400 font-medium text-gray-900"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label className="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Institutional Email Address</label>
          <input 
            type="email" 
            placeholder="j.doe@jiu.ac" 
            className="w-full px-4 py-3.5 rounded-lg bg-[#F0F2F5] border-transparent focus:bg-white focus:border-theme-blue-300 focus:ring-2 focus:ring-theme-blue-300/20 outline-none transition-all placeholder:text-gray-400 font-medium text-gray-900"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label className="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Create Password</label>
          <input 
            type="password" 
            placeholder="••••••••" 
            className="w-full px-4 py-3.5 rounded-lg bg-[#F0F2F5] border-transparent focus:bg-white focus:border-theme-blue-300 focus:ring-2 focus:ring-theme-blue-300/20 outline-none transition-all placeholder:text-gray-400 font-medium text-gray-900"
          />
        </div>

        <div className="flex items-center gap-3 mt-1">
          <input type="checkbox" id="terms" className="w-4 h-4 rounded border-gray-300 text-theme-blue-300 focus:ring-theme-blue-300/20 accent-theme-blue-300" />
          <label htmlFor="terms" className="text-xs text-gray-500 font-medium">
            I agree to the <Link href="#" className="font-bold text-theme-blue-300 hover:underline">Terms of Service</Link> and <Link href="#" className="font-bold text-theme-blue-300 hover:underline">Privacy Policy</Link> of Scholar Core.
          </label>
        </div>

        <button type="button" className="w-full mt-2 bg-theme-blue-300 hover:bg-theme-blue-200 text-white font-semibold py-3.5 rounded-lg flex justify-center items-center gap-2 transition-colors shadow-sm">
          Create Account
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
      </form>

      <div className="mt-8 text-center text-sm text-gray-500 font-medium">
        Already have an account? <Link href="/sign-in" className="font-bold text-theme-blue-300 hover:underline">Sign In</Link>
      </div>
    </div>
  );
}
