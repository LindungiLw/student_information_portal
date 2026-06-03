"use client";

import { useState } from "react";
import { 
  Globe, 
  FileText,
  BookOpen,
  LineChart,
  BookMarked
} from "lucide-react";

export default function ExternalActivitiesPage() {
  const [activeTab, setActiveTab] = useState("Internship Program");

  return (
    <div className="max-w-[1000px] mx-auto w-full flex flex-col gap-8 pb-10">
      
      {/* Breadcrumb Bar */}
      <div className="w-full bg-[#E5E7EB] rounded-xl py-3.5 px-5 flex items-center gap-3 text-gray-500 shadow-sm border border-gray-100">
        <Globe size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">External Activities</span>
      </div>

      {/* Tabs */}
      <div className="flex items-center gap-8 border-b border-gray-200">
        {["Internship Program", "Work Study Scholarship", "Student Exchange"].map((tab) => (
          <button
            key={tab}
            onClick={() => setActiveTab(tab)}
            className={`pb-3 text-sm font-bold transition-all relative ${
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
      {activeTab === "Internship Program" && (
        <div className="flex flex-col gap-6">
          
          {/* Header Card */}
          <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-theme-purple-400 flex flex-col gap-4">
            <h2 className="text-lg font-bold text-gray-900">JIU Student Internship Program</h2>
            <p className="text-xs text-gray-500 leading-relaxed max-w-5xl">
              This guideline aims to establish the objectives, procedures, and management standards of the internship program conducted by Jakarta International University (JIU) to enhance students' practical skills and social adaptability through field experience related to the student's major.
            </p>
            <button className="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-xl w-fit hover:bg-gray-50 transition-colors">
              <FileText size={16} className="text-red-500" />
              <span className="text-[11px] font-bold text-theme-purple-400">Download Internship Guideline</span>
            </button>
          </div>

          {/* Details Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div className="bg-[#FAF9FB] rounded-2xl p-6 border border-gray-200 flex flex-col gap-4">
              <div className="flex items-center gap-2 text-gray-900">
                <BookOpen size={18} />
                <h3 className="font-bold text-sm">Registration Requirements</h3>
              </div>
              <ul className="text-[11px] text-gray-500 flex flex-col gap-2 list-disc pl-4 leading-relaxed">
                <li>The student has to be an active student in the current semester.</li>
                <li>The student has to complete university courses of at least 6 semesters or 80 semester credits.</li>
                <li>The student with a minimum GPA of 2.75. (For internal internship, minimum GPA of 3.3).</li>
                <li>Every student who will register for the internship must clear unpaid tuition fees, dormitory fees, and other financial liabilities of the previous semester before applying for the internship.</li>
              </ul>
            </div>
            
            <div className="bg-[#FAF9FB] rounded-2xl p-6 border border-gray-200 flex flex-col gap-4">
              <div className="flex items-center gap-2 text-gray-900">
                <LineChart size={18} />
                <h3 className="font-bold text-sm">Evaluation Components</h3>
              </div>
              <ul className="text-[11px] text-gray-500 flex flex-col gap-2 list-disc pl-4 leading-relaxed">
                <li>The student has to be an active student in the current semester.</li>
                <li>The student has to complete university courses of at least 6 semesters or 80 semester credits.</li>
                <li>The student with a minimum GPA of 2.75. (For internal internship, minimum GPA of 3.3).</li>
                <li>Every student who will register for the internship must clear unpaid tuition fees, dormitory fees, and other financial liabilities of the previous semester before applying for the internship.</li>
              </ul>
            </div>
            
          </div>

          {/* Bottom Card */}
          <div className="bg-[#FAF9FB] rounded-xl p-4 border border-gray-200 flex items-center gap-2">
            <BookMarked size={18} className="text-gray-900" />
            <h3 className="font-bold text-sm text-gray-900">Period and Credit Hour Guidelines</h3>
          </div>

        </div>
      )}

      {/* Empty States for other tabs */}
      {activeTab === "Work Study Scholarship" && (
        <div className="bg-white border border-gray-100 rounded-3xl p-12 shadow-sm flex flex-col items-center justify-center text-center">
          <Globe size={48} className="text-gray-300 mb-4" />
          <h2 className="text-xl font-bold text-gray-900 mb-2">Work Study Scholarship</h2>
          <p className="text-sm text-gray-500 max-w-md">
            Information regarding Work Study Scholarships is currently being updated. Please check back later.
          </p>
        </div>
      )}

      {activeTab === "Student Exchange" && (
        <div className="bg-white border border-gray-100 rounded-3xl p-12 shadow-sm flex flex-col items-center justify-center text-center">
          <Globe size={48} className="text-gray-300 mb-4" />
          <h2 className="text-xl font-bold text-gray-900 mb-2">Student Exchange</h2>
          <p className="text-sm text-gray-500 max-w-md">
            Information regarding Student Exchange programs is currently being updated. Please check back later.
          </p>
        </div>
      )}

    </div>
  );
}
