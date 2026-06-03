import Link from "next/link";

export default function SignIn() {
  return (
    <div className="w-full">
      <h2 className="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Sign In</h2>
      <p className="text-gray-500 text-sm mb-10 font-medium">Make Sure You Are Login With Your JIU's Account</p>

      <div className="bg-white p-8 rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
        <form className="flex flex-col gap-6">
          <div className="flex flex-col gap-2">
            <label className="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Student ID or Email</label>
            <div className="relative">
              <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
              <input 
                type="text" 
                placeholder="e.g. ST12345 or student@jiu.ac" 
                className="w-full pl-11 pr-4 py-3.5 rounded-lg bg-[#F4F5F7] border border-transparent focus:bg-white focus:border-theme-blue-300 focus:ring-2 focus:ring-theme-blue-300/20 outline-none transition-all placeholder:text-gray-400 font-medium text-gray-900"
              />
            </div>
          </div>

          <div className="flex flex-col gap-2">
            <div className="flex justify-between items-center">
              <label className="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Password</label>
              <Link href="#" className="text-[11px] font-bold text-theme-blue-300 hover:underline">Forgot password?</Link>
            </div>
            <div className="relative">
              <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              </div>
              <input 
                type="password" 
                placeholder="••••••••" 
                className="w-full pl-11 pr-12 py-3.5 rounded-lg bg-[#F4F5F7] border border-transparent focus:bg-white focus:border-theme-blue-300 focus:ring-2 focus:ring-theme-blue-300/20 outline-none transition-all placeholder:text-gray-400 font-medium text-gray-900"
              />
              <button type="button" className="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>

          <div className="flex items-center gap-3 mt-1">
            <input type="checkbox" id="remember" className="w-4 h-4 rounded border-gray-300 text-theme-blue-300 focus:ring-theme-blue-300/20 accent-theme-blue-300" />
            <label htmlFor="remember" className="text-xs text-gray-500 font-medium">
              Remember me for 30 days
            </label>
          </div>

          <button type="button" className="w-full mt-2 bg-theme-blue-300 hover:bg-theme-blue-200 text-white font-semibold py-3.5 rounded-lg flex justify-center items-center transition-colors shadow-sm">
            Sign In
          </button>
        </form>
      </div>

      <div className="mt-8 text-center text-sm text-gray-500 font-medium">
        New to the platform? <Link href="/sign-up" className="font-bold text-theme-blue-300 hover:underline">Create an account</Link>
      </div>
    </div>
  );
}
