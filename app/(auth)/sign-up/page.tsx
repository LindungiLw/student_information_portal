"use client";
import Link from "next/link";
import { useRouter } from "next/navigation";

export default function SignUp() {
  const router = useRouter();

  const handleGoogleSignUp = () => {
    const email = prompt("Enter your Google Account email (Simulated OAuth flow):");
    if (!email) return;

    if (email.endsWith("@jiu.ac")) {
      alert("Success! Authenticated via Google Workspace.");
      router.push("/dashboard");
    } else {
      alert("Access Denied: Only @jiu.ac accounts are allowed to use SSO.");
    }
  };

  return (
    <div className="w-full">
      <h2 className="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Create Account</h2>
      <p className="text-gray-500 text-sm mb-10 font-medium">Make Sure You Are Register With Your JIU's Account</p>

      {/* Google SSO Button */}
      <button 
        onClick={handleGoogleSignUp}
        type="button"
        className="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-lg transition-colors shadow-sm mb-6"
      >
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22.56 12.25C22.56 11.47 22.49 10.72 22.36 10H12V14.26H17.92C17.66 15.63 16.88 16.79 15.71 17.57V20.34H19.28C21.36 18.42 22.56 15.6 22.56 12.25Z" fill="#4285F4"/>
          <path d="M12 23C14.97 23 17.46 22.02 19.28 20.34L15.71 17.57C14.72 18.23 13.47 18.63 12 18.63C9.16 18.63 6.75 16.71 5.88 14.14H2.21V16.98C4.01 20.56 7.71 23 12 23Z" fill="#34A853"/>
          <path d="M5.88 14.14C5.66 13.48 5.53 12.76 5.53 12C5.53 11.24 5.66 10.52 5.88 9.86V7.02H2.21C1.48 8.48 1.07 10.18 1.07 12C1.07 13.82 1.48 15.52 2.21 16.98L5.88 14.14Z" fill="#FBBC05"/>
          <path d="M12 5.38C13.62 5.38 15.07 5.94 16.22 7.03L19.36 3.89C17.46 2.12 14.97 1.07 12 1.07C7.71 1.07 4.01 3.44 2.21 7.02L5.88 9.86C6.75 7.29 9.16 5.38 12 5.38Z" fill="#EA4335"/>
        </svg>
        Continue with Google
      </button>

      {/* Divider */}
      <div className="flex items-center gap-4 mb-6">
        <div className="flex-1 h-px bg-gray-200"></div>
        <span className="text-xs font-bold text-gray-400 uppercase tracking-widest">Or</span>
        <div className="flex-1 h-px bg-gray-200"></div>
      </div>

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
