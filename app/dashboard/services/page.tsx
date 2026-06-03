"use client";

import { useState } from "react";
import { 
  Headphones,
  Building,
  Utensils,
  HeartHandshake,
  CalendarPlus,
  Clock,
  TriangleAlert,
  FileText,
  FileSpreadsheet,
  FileImage,
  ExternalLink,
  Download,
  QrCode
} from "lucide-react";

export default function StudentServicesPage() {
  const [activeTab, setActiveTab] = useState("Dormitory");

  const tabs = [
    "Dormitory", 
    "JIU Student Counseling", 
    "Library", 
    "Forms", 
    "Feedback and Report"
  ];

  return (
    <div className="max-w-[1000px] mx-auto w-full flex flex-col gap-8 pb-10">
      
      {/* Breadcrumb Bar */}
      <div className="w-full bg-[#E5E7EB] rounded-xl py-3.5 px-5 flex items-center gap-3 text-gray-500 shadow-sm border border-gray-100">
        <Headphones size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">Student Services</span>
      </div>

      {/* Tabs */}
      <div className="flex items-center gap-8 border-b border-gray-200 overflow-x-auto custom-scrollbar">
        {tabs.map((tab) => (
          <button
            key={tab}
            onClick={() => setActiveTab(tab)}
            className={`pb-3 text-sm font-bold transition-all relative whitespace-nowrap ${
              activeTab === tab 
                ? "text-theme-purple-400" 
                : "text-gray-400 hover:text-gray-600"
            }`}
          >
            {tab}
            {activeTab === tab && (
              <div className="absolute bottom-0 left-0 w-full h-[3px] bg-theme-purple-400 rounded-t-full"></div>
            )}
          </button>
        ))}
      </div>

      {/* Dynamic Content */}
      {activeTab === "Dormitory" && (
        <div className="flex flex-col gap-6">
          
          {/* Header Card */}
          <div className="bg-[#F4EDFC] rounded-2xl p-8 shadow-sm border border-gray-100 border-l-4 border-l-theme-purple-400 flex flex-col gap-4">
            <h2 className="text-xl font-bold text-gray-900">Thomas House Dormitory</h2>
            <p className="text-sm text-gray-600 leading-relaxed max-w-5xl">
              The Jakarta International University (JIU) dormitory is called Thomas House. This dormitory serves as a facility for fostering and empowering JIU students in accordance with the core values of Love, Integrity, Faithfulness, and Excellence (L.I.F.E.).
            </p>
          </div>

          {/* Details Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
            
            <div className="bg-white rounded-2xl p-8 border border-gray-200 flex flex-col gap-5 shadow-sm">
              <div className="flex items-center gap-2 text-gray-900">
                <Building size={18} className="text-theme-purple-400" />
                <h3 className="font-bold text-base">General & Time Rules</h3>
              </div>
              <ul className="text-xs text-gray-500 flex flex-col gap-4 list-disc pl-4 leading-relaxed">
                <li>Freshmen students are required to live in the dormitory for one year after being accepted as JIU students.</li>
                <li>Quiet Hour: Valid from 10:00 p.m. to 6:00 a.m. All noisy activities must cease during this time.</li>
                <li>Evening Return Time: Residents must return to the dormitory the latest at 7:00 p.m. on Mondays to Thursdays; while on Fridays to Sundays latest at 8:00 p.m.</li>
              </ul>
            </div>
            
            <div className="bg-white rounded-2xl p-8 border border-gray-200 flex flex-col gap-5 shadow-sm">
              <div className="flex items-center gap-2 text-gray-900">
                <Utensils size={18} className="text-theme-purple-400" />
                <h3 className="font-bold text-base">Facilities & Conduct</h3>
              </div>
              <ul className="text-xs text-gray-500 flex flex-col gap-4 list-disc pl-4 leading-relaxed">
                <li>A mini kitchen (pantry) is available for cooking simple meals, heating food, and boiling water.</li>
                <li>Each dormitory resident receives 30 merit points at the beginning of the semester.</li>
                <li>Merit points can be earned by actively participating in dormitory activities, maintaining cleanliness, and demonstrating a positive attitude.</li>
              </ul>
            </div>
            
          </div>

        </div>
      )}

      {/* JIU Student Counseling Tab */}
      {activeTab === "JIU Student Counseling" && (
        <div className="flex flex-col gap-6">
          
          {/* Header Card */}
          <div className="bg-gradient-to-r from-[#FFF0F5] to-white rounded-2xl p-8 shadow-sm border border-gray-100 border-l-4 border-l-[#D81B60] flex flex-col gap-4">
            <h2 className="text-xl font-bold text-[#D81B60]">Facing challenges in life and studies? We're here to help!</h2>
            <p className="text-sm text-gray-600 leading-relaxed max-w-5xl">
              Confidential and supportive counseling sessions designed to guide you through your university journey.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
            
            {/* What We Offer Card */}
            <div className="md:col-span-2 bg-white rounded-2xl p-8 border border-gray-200 flex flex-col gap-5 shadow-sm">
              <div className="flex items-center gap-2 text-[#D81B60]">
                <HeartHandshake size={20} />
                <h3 className="font-bold text-base">What We Offer</h3>
              </div>
              <ul className="flex flex-col gap-4">
                {[
                  "Personalized guidance for your personal life, spiritual journey and academic success.",
                  "Confidential and supportive counseling sessions.",
                  "Helping you navigate challenges in faith, studies, and life.",
                  "Encouragement, wisdom, and practical strategies for growth."
                ].map((item, idx) => (
                  <li key={idx} className="flex items-start gap-3">
                    <div className="mt-0.5 w-1.5 h-1.5 rounded-full bg-[#D81B60] flex-shrink-0"></div>
                    <span className="text-xs text-gray-500 leading-relaxed">{item}</span>
                  </li>
                ))}
              </ul>
            </div>

            {/* Quick Contact / Action Card to make it "lebih bagus" */}
            <div className="bg-[#D81B60] rounded-2xl p-8 border border-transparent flex flex-col gap-5 shadow-sm text-white justify-between">
              <div className="flex flex-col gap-2">
                <h3 className="font-bold text-lg">Ready to talk?</h3>
                <p className="text-xs text-white/80 leading-relaxed">
                  Schedule a private and secure one-on-one session with our certified counselors today.
                </p>
              </div>
              <button className="bg-white text-[#D81B60] py-3 px-4 rounded-xl text-xs font-bold shadow-md hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                <CalendarPlus size={16} /> Book a Session
              </button>
            </div>
            
          </div>

        </div>
      )}

      {/* Library Tab */}
      {activeTab === "Library" && (
        <div className="flex flex-col gap-6">
          
          {/* Header Card */}
          <div className="bg-gradient-to-r from-[#FFF9E6] to-white rounded-2xl p-8 shadow-sm border border-gray-100 border-l-4 border-l-[#D97706] flex flex-col gap-4">
            <h2 className="text-xl font-bold text-[#D97706]">Dream Blue Library (JIU Library)</h2>
            <p className="text-sm text-[#B45309] leading-relaxed max-w-5xl">
              Location: K-Eduplex, Jl. Ganesha2, Lot B1, Deltamas, Pasirranji Village, Central Cikarang District, Bekasi Regency, West Java 17530.
            </p>
          </div>

          {/* Details Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
            
            <div className="bg-white rounded-2xl p-8 border border-gray-200 flex flex-col gap-5 shadow-sm">
              <div className="flex items-center gap-2 text-[#D97706]">
                <Clock size={18} />
                <h3 className="font-bold text-base">Operational Hours & Access</h3>
              </div>
              <ul className="text-xs text-gray-500 flex flex-col gap-4 list-disc pl-4 leading-relaxed">
                <li>Regular opening hours are 08.00-17.00.</li>
                <li>Visitors can utilize OPAC to access information about the library's collection catalog by logging in to http://lib.jiu.ac/.</li>
              </ul>
            </div>
            
            <div className="bg-white rounded-2xl p-8 border border-gray-200 flex flex-col gap-5 shadow-sm">
              <div className="flex items-center gap-2 text-[#D97706]">
                <TriangleAlert size={18} />
                <h3 className="font-bold text-base">Important Rules</h3>
              </div>
              <ul className="text-xs text-gray-500 flex flex-col gap-4 list-disc pl-4 leading-relaxed">
                <li>Bringing colored and flavored food and drinks is prohibited. Only mineral water is allowed.</li>
                <li>Visitors are not allowed to adjust the air conditioning temperature in the reading rooms without permission from the librarian. The AC temperature should only be set around 25-26°C.</li>
              </ul>
            </div>
            
          </div>

        </div>
      )}

      {/* Forms Tab */}
      {activeTab === "Forms" && (
        <div className="flex flex-col gap-6">
          
          {/* Header Card */}
          <div className="bg-gradient-to-r from-blue-50 to-white rounded-2xl p-8 shadow-sm border border-gray-100 border-l-4 border-l-blue-600 flex flex-col gap-4">
            <h2 className="text-xl font-bold text-blue-700">Document Center</h2>
            <p className="text-sm text-blue-600/80 leading-relaxed max-w-5xl">
              Access essential university forms and documents quickly.
            </p>
          </div>

          {/* Document List */}
          <div className="flex flex-col gap-3">
            
            {/* Document 1 */}
            <div className="bg-white rounded-2xl p-5 border border-gray-200 flex items-center justify-between shadow-sm hover:border-blue-300 hover:shadow-md transition-all group cursor-pointer">
              <div className="flex items-center gap-4">
                <div className="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                  <FileText size={20} />
                </div>
                <div className="flex flex-col">
                  <h3 className="font-bold text-sm text-gray-900 group-hover:text-blue-600 transition-colors">SSS Program Agreement</h3>
                  <p className="text-[11px] text-gray-500">Google Docs</p>
                </div>
              </div>
              <button className="flex items-center gap-2 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors px-3 py-1.5 rounded-lg hover:bg-blue-50">
                Open Link <ExternalLink size={14} />
              </button>
            </div>

            {/* Document 2 */}
            <div className="bg-white rounded-2xl p-5 border border-gray-200 flex items-center justify-between shadow-sm hover:border-blue-300 hover:shadow-md transition-all group cursor-pointer">
              <div className="flex items-center gap-4">
                <div className="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                  <FileSpreadsheet size={20} />
                </div>
                <div className="flex flex-col">
                  <h3 className="font-bold text-sm text-gray-900 group-hover:text-blue-600 transition-colors">Student Service Report Form</h3>
                  <p className="text-[11px] text-gray-500">Google Spreadsheet</p>
                </div>
              </div>
              <button className="flex items-center gap-2 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors px-3 py-1.5 rounded-lg hover:bg-blue-50">
                Open Link <ExternalLink size={14} />
              </button>
            </div>

            {/* Document 3 */}
            <div className="bg-white rounded-2xl p-5 border border-gray-200 flex items-center justify-between shadow-sm hover:border-blue-300 hover:shadow-md transition-all group cursor-pointer">
              <div className="flex items-center gap-4">
                <div className="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                  <FileText size={20} />
                </div>
                <div className="flex flex-col">
                  <h3 className="font-bold text-sm text-gray-900 group-hover:text-blue-600 transition-colors">Tuition Fee Deferral Request</h3>
                  <p className="text-[11px] text-gray-500">Google Docs</p>
                </div>
              </div>
              <button className="flex items-center gap-2 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors px-3 py-1.5 rounded-lg hover:bg-blue-50">
                Open Link <ExternalLink size={14} />
              </button>
            </div>

            {/* Document 4 */}
            <div className="bg-white rounded-2xl p-5 border border-gray-200 flex items-center justify-between shadow-sm hover:border-blue-300 hover:shadow-md transition-all group cursor-pointer">
              <div className="flex items-center gap-4">
                <div className="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                  <FileImage size={20} />
                </div>
                <div className="flex flex-col">
                  <h3 className="font-bold text-sm text-gray-900 group-hover:text-blue-600 transition-colors">Tuition Fee Deferral Request</h3>
                  <p className="text-[11px] text-gray-500">PDF Document</p>
                </div>
              </div>
              <button className="flex items-center gap-2 text-[11px] font-bold text-[#4B1B8A] hover:text-[#2c1a65] transition-colors px-3 py-1.5 rounded-lg hover:bg-purple-50">
                Download <Download size={14} />
              </button>
            </div>

          </div>

        </div>
      )}

      {/* Feedback and Report Tab */}
      {activeTab === "Feedback and Report" && (
        <div className="flex flex-col items-center justify-center py-8">
          <div className="bg-white border-2 border-blue-500 rounded-[30px] p-12 shadow-sm flex flex-col items-center text-center max-w-xl w-full gap-8">
            <h2 className="text-2xl font-bold text-gray-900">Academic Affairs Needs Your Voice!</h2>
            
            <div className="bg-white p-4 border border-gray-200 rounded-2xl shadow-sm">
              <QrCode size={180} strokeWidth={1.2} className="text-gray-900" />
            </div>
            
            <p className="text-sm text-gray-600 leading-relaxed max-w-md">
              Do you have any challenges or concerns about your class?<br/>
              Please share your feedback via this form.
            </p>
          </div>
        </div>
      )}

    </div>
  );
}
