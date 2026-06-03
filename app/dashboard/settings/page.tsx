"use client";
import { 
  Search, 
  Bell, 
  Info, 
  SlidersHorizontal, 
  Shield, 
  User, 
  Users, 
  LogOut,
  Camera
} from "lucide-react";
import { useRouter } from "next/navigation";

export default function SettingsPage() {
  const router = useRouter();

  const handleLogout = () => {
    if (window.confirm("Are you sure you want to log out?")) {
      router.push("/sign-in");
    }
  };

  return (
    <div className="w-full max-w-[1200px] mx-auto flex flex-col pb-10">
      
      {/* Top Navigation Bar */}
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 w-full">
        {/* Search Bar */}
        <div className="relative w-full md:w-[400px]">
          <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <Search size={16} className="text-gray-400" />
          </div>
          <input 
            type="text" 
            placeholder="Search settings..." 
            className="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-theme-purple-400 focus:border-transparent transition-all shadow-sm"
          />
        </div>

        {/* Right Actions */}
        <div className="flex items-center gap-4 self-end md:self-auto">
          <button className="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
            <Bell size={20} />
            <span className="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">
              3
            </span>
          </button>
          <div className="w-9 h-9 rounded-full bg-[#8E5AEC] text-white flex items-center justify-center text-sm font-bold shadow-md cursor-pointer hover:opacity-90 transition-opacity">
            FP
          </div>
        </div>
      </div>

      {/* Settings Header */}
      <div className="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
        <div className="flex flex-col gap-1">
          <h1 className="text-2xl font-bold text-gray-900 tracking-tight">Settings</h1>
          <p className="text-sm text-gray-500">Manage your account settings and preferences.</p>
        </div>
        <div className="flex items-center gap-3 w-full md:w-auto">
          <button className="flex-1 md:flex-none px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-xs rounded-xl shadow-sm hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button className="flex-1 md:flex-none px-6 py-2.5 bg-[#5A67BA] hover:bg-[#4a55a2] text-white font-bold text-xs rounded-xl shadow-sm transition-colors">
            Save Changes
          </button>
        </div>
      </div>

      {/* Main Settings Container */}
      <div className="flex flex-col md:flex-row gap-2 bg-white rounded-3xl p-3 shadow-sm border border-gray-100 min-h-[600px]">
        
        {/* Sidebar */}
        <div className="w-full md:w-64 flex flex-col gap-1 border-b md:border-b-0 md:border-r border-gray-100 pr-0 md:pr-3 pb-4 md:pb-0">
          
          <button className="flex items-center gap-3 w-full px-4 py-3 bg-[#F4EDFC] text-[#5A67BA] rounded-xl font-bold text-sm transition-colors text-left">
            <Info size={18} /> General Information
          </button>
          
          <button className="flex items-center gap-3 w-full px-4 py-3 text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl font-medium text-sm transition-colors text-left">
            <SlidersHorizontal size={18} /> Preferences
          </button>
          
          <button className="flex items-center gap-3 w-full px-4 py-3 text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl font-medium text-sm transition-colors text-left">
            <Shield size={18} /> Security
          </button>
          
          <button className="flex items-center gap-3 w-full px-4 py-3 text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl font-medium text-sm transition-colors text-left">
            <Bell size={18} /> Notifications
          </button>
          
          <button className="flex items-center gap-3 w-full px-4 py-3 text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl font-medium text-sm transition-colors text-left">
            <User size={18} /> Account
          </button>
          
          <button className="flex items-center gap-3 w-full px-4 py-3 text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl font-medium text-sm transition-colors text-left">
            <Users size={18} /> Account Manager
          </button>
          
          <div className="mt-auto pt-4 border-t border-gray-100">
            <button 
              onClick={handleLogout}
              className="flex items-center gap-3 w-full px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-medium text-sm transition-colors text-left"
            >
              <LogOut size={18} /> Log Out
            </button>
          </div>
          
        </div>

        {/* Content Area */}
        <div className="flex-1 p-4 md:p-8 flex flex-col">
          
          <h2 className="text-xl font-bold text-gray-900 mb-1">General Information</h2>
          <p className="text-sm text-gray-500">Update your personal and academic information.</p>
          
          <hr className="my-8 border-gray-100" />
          
          <h3 className="font-bold text-gray-900 mb-4">Profile picture upload</h3>
          
          {/* Profile Upload Card */}
          <div className="bg-gray-50 rounded-2xl p-6 border border-gray-100 flex flex-col sm:flex-row items-center sm:items-start gap-8 shadow-sm">
            
            {/* Avatar */}
            <div className="relative">
              <div className="w-24 h-24 rounded-full bg-gray-200 border-4 border-white flex items-center justify-center shadow-sm text-gray-400">
                <User size={40} />
              </div>
              <div className="absolute bottom-0 right-0 w-8 h-8 bg-[#5A67BA] rounded-full border-2 border-white flex items-center justify-center text-white shadow-sm cursor-pointer hover:bg-[#4a55a2] transition-colors">
                <Camera size={14} />
              </div>
            </div>
            
            {/* Info & Actions */}
            <div className="flex flex-col items-center sm:items-start flex-1 text-center sm:text-left gap-1">
              <h4 className="text-lg font-bold text-gray-900 leading-tight">Firman<br/>Christian<br/>Purba</h4>
              <p className="text-xs text-[#5A67BA] mt-2 font-medium">Information Systems Student</p>
              <p className="text-[11px] text-gray-400">Jakarta International University</p>
            </div>
            
            <div className="flex flex-col gap-3 w-full sm:w-auto mt-4 sm:mt-0">
              <button className="px-5 py-2.5 bg-[#5A67BA] hover:bg-[#4a55a2] text-white font-bold text-xs rounded-xl shadow-sm transition-colors w-full">
                Upload New Photo
              </button>
              <button className="px-5 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-bold text-xs rounded-xl shadow-sm transition-colors w-full">
                Delete
              </button>
            </div>
            
          </div>
          
        </div>
        
      </div>
      
    </div>
  );
}
