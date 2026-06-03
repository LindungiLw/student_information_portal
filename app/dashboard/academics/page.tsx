"use client";

import { useState } from "react";
import Image from "next/image";
import {
  GraduationCap,
  Search,
  Clock,
  ChevronDown,
  ChevronUp,
  BookOpen,
  Users,
  Star,
  Calculator,
  Calendar,
  Clock4,
  Stethoscope,
  UserX,
  FileText,
  FileCheck,
  Wallet,
  ClipboardCheck,
  ShieldCheck,
  Banknote,
  TriangleAlert,
  Scale,
  ShieldAlert,
  Hourglass,
  UserCheck
} from "lucide-react";

export default function AcademicsPage() {
  const [activeTab, setActiveTab] = useState("Academic & Status");
  const [expandedSections, setExpandedSections] = useState<Record<string, boolean>>({
    lengthOfStudy: true,
    gradingPolicy: true,
    gpaCalculation: true,
    appeals: true,
  });

  const toggleSection = (section: string) => {
    setExpandedSections(prev => ({
      ...prev,
      [section]: !prev[section]
    }));
  };

  const Accordion = ({
    id,
    icon,
    title,
    subtitle,
    children
  }: {
    id: string,
    icon: React.ReactNode,
    title: string,
    subtitle?: string,
    children: React.ReactNode
  }) => {
    const isExpanded = expandedSections[id];

    return (
      <div className="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm mb-4">
        <button
          onClick={() => toggleSection(id)}
          className="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors"
        >
          <div className="flex items-center gap-4">
            <div className="w-10 h-10 rounded-xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
              {icon}
            </div>
            <div className="flex flex-col">
              <span className="font-bold text-gray-900">{title}</span>
              {subtitle && <span className="text-xs text-gray-500 mt-0.5">{subtitle}</span>}
            </div>
          </div>
          <div className="text-gray-400">
            {isExpanded ? <ChevronUp size={20} /> : <ChevronDown size={20} />}
          </div>
        </button>

        {isExpanded && (
          <div className="p-6 pt-2 border-t border-gray-50">
            {children}
          </div>
        )}
      </div>
    );
  };

  const TABS = [
    "Program Structure and Credit Terms",
    "Academic Leave & Inactive Status",
    "Judiciary & Graduation Process",
    "Academic & Status"
  ];

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
      <div className="w-full bg-[#F3F4F6] rounded-xl py-3.5 px-5 flex items-center gap-3 text-gray-500 shadow-sm border border-gray-100">
        <GraduationCap size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">Academic</span>
      </div>

      {/* Header & Search */}
      <div className="flex flex-col gap-6 bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)]">
        <div className="flex flex-col md:flex-row md:items-start justify-between gap-4">
          <div className="flex flex-col">
            <h1 className="text-2xl font-bold text-gray-900 mb-1">Academic Policies & Procedures</h1>
            <p className="text-sm text-gray-500">Essential guidelines governing academic life, from registration protocols to graduation requirements and student conduct.</p>
          </div>
          <button className="px-4 py-2 bg-theme-purple-100/20 text-theme-purple-400 font-bold text-[11px] uppercase tracking-wider rounded-lg border border-theme-purple-100/50 hover:bg-theme-purple-100/30 transition-colors flex-shrink-0">
            DOWNLOAD DOCUMENT &rarr;
          </button>
        </div>

        <div className="relative w-full">
          <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-theme-purple-300">
            <Search size={18} />
          </div>
          <input
            type="text"
            placeholder="Search for specific policies (e.g., 'Late Enrollment', 'GPA Calculation')"
            className="w-full pl-11 pr-4 py-3.5 bg-[#F9FAFB] border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-theme-purple-200 transition-all placeholder:text-gray-400"
          />
        </div>

        {/* Tabs */}
        <div className="flex items-center gap-1 overflow-x-auto custom-scrollbar border-b border-gray-200 mt-2">
          {TABS.map((tab, idx) => {
            const isActive = tab === activeTab;
            return (
              <button
                key={tab}
                onClick={() => setActiveTab(tab)}
                className={`whitespace-nowrap py-3 px-1 border-b-2 font-semibold text-[13px] transition-colors ${isActive
                    ? "border-theme-purple-400 text-theme-purple-400"
                    : "border-transparent text-gray-400 hover:text-gray-600"
                  } ${idx > 0 ? 'ml-6' : ''}`}
              >
                {tab}
              </button>
            );
          })}
        </div>
      </div>

      {activeTab === "Program Structure and Credit Terms" && (
        <>
          {/* Accordions Section 1 */}
          <div className="flex flex-col">
            <Accordion
              id="lengthOfStudy"
              icon={<Clock size={20} />}
              title="Length of Study"
              subtitle="Maximum duration for Bachelor's degrees."
            >
              <p className="text-sm text-gray-600 leading-relaxed">
                Undergraduate programs must be completed within a maximum of 14 semesters (7 academic years). Students unable to adhere to this timeline may face dismissal (Drop Out/Termination).
              </p>
            </Accordion>
            <Accordion id="academicCredits" icon={<BookOpen size={20} />} title="Academic Credits" subtitle="Credit hour definitions and load requirements.">
              <p className="text-sm text-gray-600 leading-relaxed">Information about academic credits will be displayed here.</p>
            </Accordion>
            <Accordion id="classAttendance" icon={<Users size={20} />} title="Class Attendance" subtitle="Mandatory attendance and absence policies.">
              <p className="text-sm text-gray-600 leading-relaxed">Information about class attendance will be displayed here.</p>
            </Accordion>
          </div>
          {/* Split Cards: Assessment & Exam Rules */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm">
              <h3 className="font-bold text-gray-900 mb-5">Assessment Components</h3>
              <ul className="flex flex-col gap-3">
                <li className="flex items-start gap-3">
                  <div className="w-1.5 h-1.5 rounded-full bg-theme-purple-400 mt-2 flex-shrink-0"></div>
                  <span className="text-sm text-gray-600">Continuous Assessment (Quizzes, Assignments) = <strong>30-40%</strong></span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-1.5 h-1.5 rounded-full bg-theme-purple-400 mt-2 flex-shrink-0"></div>
                  <span className="text-sm text-gray-600">Mid-Term Examination (UTS) = <strong>30%</strong></span>
                </li>
                <li className="flex items-start gap-3">
                  <div className="w-1.5 h-1.5 rounded-full bg-theme-purple-400 mt-2 flex-shrink-0"></div>
                  <span className="text-sm text-gray-600">Final Examination (UAS) = <strong>30-40%</strong></span>
                </li>
              </ul>
            </div>
            <div className="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm">
              <h3 className="font-bold text-gray-900 mb-3">Examination Rules</h3>
              <p className="text-sm text-gray-600 leading-relaxed mb-5">
                Final examinations are compulsory for all students. Any exceptions require prior approval from Academic Affairs. Late arrivals exceeding 30 minutes may be denied entry.
              </p>
              <button className="text-[11px] font-bold text-theme-purple-400 uppercase tracking-wider hover:underline">
                DOWNLOAD EXAM PROCEDURES &rarr;
              </button>
            </div>
          </div>
          {/* Accordions Section 2 */}
          <div className="flex flex-col">
            <Accordion id="gradingPolicy" icon={<Star size={20} />} title="Grading Policy & Conversion" subtitle="Marks to grade letter/point mappings.">
              <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse">
                  <thead>
                    <tr className="border-b border-gray-100">
                      <th className="py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-1/4">Marks Range</th>
                      <th className="py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-1/4">Grade</th>
                      <th className="py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-1/4">Point</th>
                      <th className="py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider w-1/4">Description</th>
                    </tr>
                  </thead>
                  <tbody className="text-sm">
                    {[
                      { range: "85 - 100", grade: "A", point: "4.00", desc: "Excellent", color: "text-theme-purple-400" },
                      { range: "80 - 84", grade: "A-", point: "3.75", desc: "Superior", color: "text-theme-purple-400" },
                      { range: "75 - 79", grade: "B+", point: "3.50", desc: "Very Good", color: "text-theme-purple-400" },
                      { range: "70 - 74", grade: "B", point: "3.00", desc: "Good", color: "text-theme-purple-400" },
                      { range: "65 - 69", grade: "B-", point: "2.75", desc: "Above Average", color: "text-theme-purple-400" },
                      { range: "60 - 64", grade: "C+", point: "2.50", desc: "Average", color: "text-theme-purple-400" },
                      { range: "55 - 59", grade: "C", point: "2.00", desc: "Fair", color: "text-theme-purple-400" },
                      { range: "45 - 54", grade: "D", point: "1.00", desc: "Poor", color: "text-theme-purple-400" },
                      { range: "0 - 44", grade: "E", point: "0.00", desc: "Failure", color: "text-red-500" },
                    ].map((row, i) => (
                      <tr key={i} className="border-b border-gray-50 last:border-0">
                        <td className="py-3 text-gray-600">{row.range}</td>
                        <td className={`py-3 font-bold ${row.color}`}>{row.grade}</td>
                        <td className="py-3 text-gray-600">{row.point}</td>
                        <td className="py-3 text-gray-500">{row.desc}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </Accordion>
            <Accordion id="gpaCalculation" icon={<Calculator size={20} />} title="GPA Calculation & Honors" subtitle="How GPA is calculated and graduation honors.">
              <div className="flex flex-col gap-6">
                <div>
                  <h4 className="text-xs font-bold text-gray-800 uppercase mb-2 tracking-wide">GPA Calculation Formula</h4>
                  <p className="text-sm text-gray-600">GPA = Sum(Grade Points × Credits) / Total Credits</p>
                </div>

                <div className="bg-[#F8F9FB] rounded-xl p-4 border border-gray-100">
                  <p className="text-xs text-gray-500 leading-relaxed font-mono">
                    Course 1 (3 cr, Grade A/4.0) = 3 × 4.0 = 12<br />
                    Course 2 (4 cr, Grade B/3.0) = 4 × 3.0 = 12<br />
                    Total: 24 points / 7 credits = GPA 3.43
                  </p>
                </div>

                <div>
                  <h4 className="text-xs font-bold text-gray-800 uppercase mb-3 tracking-wide">Academic Honors (Yudisium)</h4>
                  <ul className="flex flex-col gap-2">
                    <li className="flex items-center gap-3">
                      <span className="w-1.5 h-1.5 rounded-full bg-theme-purple-400"></span>
                      <span className="text-sm text-gray-700"><strong>Summa Cum Laude:</strong> GPA 3.90 - 4.00</span>
                    </li>
                    <li className="flex items-center gap-3">
                      <span className="w-1.5 h-1.5 rounded-full bg-theme-purple-400"></span>
                      <span className="text-sm text-gray-700"><strong>Magna Cum Laude:</strong> GPA 3.70 - 3.89</span>
                    </li>
                    <li className="flex items-center gap-3">
                      <span className="w-1.5 h-1.5 rounded-full bg-theme-purple-400"></span>
                      <span className="text-sm text-gray-700"><strong>Cum Laude:</strong> GPA 3.50 - 3.69</span>
                    </li>
                  </ul>
                </div>
              </div>
            </Accordion>
          </div>
          {/* Transcript Card */}
          <div className="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div className="flex flex-col items-start">
              <h3 className="font-bold text-gray-900 mb-3 text-lg">Transcript of Records (TOR)</h3>
              <p className="text-sm text-gray-600 leading-relaxed mb-6">
                Official document detailing all subjects graded, and cumulative GPA required for graduation or transfer programs.
              </p>
              <button className="px-5 py-2.5 bg-[#4B1B8A] text-white font-bold text-xs rounded-xl shadow-md hover:bg-[#3d1573] transition-colors">
                REQUEST OFFICIAL TOR
              </button>
            </div>
            <div className="relative h-[180px] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-100 border border-gray-200">
              <Image src="/image.png" alt="Transcript Document" fill sizes="100vw" className="object-cover opacity-80" />
            </div>
          </div>
          {/* Administrative Transitions */}
          <div className="flex flex-col mt-4">
            <h2 className="text-lg font-bold text-gray-900 mb-5">Administrative Transitions</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
              <div className="bg-[#F8F9FB] rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col">
                <h4 className="text-xs font-bold text-theme-blue-300 uppercase mb-3">Academic Transfer</h4>
                <p className="text-xs text-gray-500 leading-relaxed">
                  Process for changing faculties or transferring credits from other institutions. Deadline: Semester 3.
                </p>
              </div>
              <div className="bg-[#F8F9FB] rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col">
                <h4 className="text-xs font-bold text-theme-purple-300 uppercase mb-3">Academic Leave</h4>
                <p className="text-xs text-gray-500 leading-relaxed">
                  Temporary absence for 1-2 semesters. Student status remains active but no academic activities allowed.
                </p>
              </div>
              <div className="bg-[#F8F9FB] rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col">
                <h4 className="text-xs font-bold text-gray-700 uppercase mb-3">Re-enrollment</h4>
                <p className="text-xs text-gray-500 leading-relaxed">
                  Formal process to return to active study after a period of leave or unapproved absence.
                </p>
              </div>
              <div className="bg-[#FFF5F5] rounded-2xl p-5 border border-red-100 shadow-sm flex flex-col">
                <h4 className="text-xs font-bold text-red-500 uppercase mb-3">Drop Out / Termination</h4>
                <p className="text-xs text-gray-500 leading-relaxed">
                  Involuntary withdrawal for academic failure (e.g. low GPA), expired study limit, or severe violations.
                </p>
              </div>
            </div>
            <Accordion id="appeals" icon={<Scale size={20} />} title="Appeals" subtitle="Procedures for grade reviews and grievance resolution.">
              <div className="flex flex-col gap-3">
                <p className="text-sm text-gray-600">Students have the right to appeal grades within 7 days of release.</p>
                <p className="text-sm text-gray-600">Grievance against instructors or administration follows the formal complaints procedure outlined in the handbook.</p>
              </div>
            </Accordion>
          </div>
        </>
      )}

      {activeTab === "Academic Leave & Inactive Status" && (
        <div className="flex flex-col gap-6">

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {/* Left Card: Standard Academic Leave */}
            <div className="lg:col-span-2 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col">
              <div className="flex items-center gap-4 mb-6">
                <div className="w-12 h-12 rounded-2xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
                  <Calendar size={24} />
                </div>
                <h2 className="text-lg font-bold text-gray-900">Standard Academic Leave</h2>
              </div>

              <p className="text-gray-600 text-sm leading-relaxed mb-8">
                Students are entitled to a maximum of <strong className="text-theme-purple-400 underline decoration-2 underline-offset-4">two (2) semesters</strong> of authorized academic leave during their entire degree program.
              </p>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div className="bg-[#F8F9FB] rounded-2xl p-5 border border-gray-100">
                  <div className="flex items-center gap-3 mb-2">
                    <Clock4 size={18} className="text-[#B97A56]" />
                    <h4 className="text-sm font-bold text-gray-900">Time Calculation</h4>
                  </div>
                  <p className="text-xs text-gray-500 leading-relaxed">
                    Leave periods are <strong>not counted</strong> towards the total length of study limits.
                  </p>
                </div>

                <div className="bg-[#F8F9FB] rounded-2xl p-5 border border-gray-100">
                  <div className="flex items-center gap-3 mb-2">
                    <Stethoscope size={18} className="text-[#B97A56]" />
                    <h4 className="text-sm font-bold text-gray-900">Medical Extension</h4>
                  </div>
                  <p className="text-xs text-gray-500 leading-relaxed">
                    Possible extensions beyond 2 semesters with certified medical documentation.
                  </p>
                </div>
              </div>

              <div className="mt-auto self-center md:self-start w-full flex justify-center">
                <button className="text-[11px] font-bold text-theme-purple-300 uppercase tracking-wider hover:underline">
                  APPLY FOR LEAVE &rarr;
                </button>
              </div>
            </div>

            {/* Right Card: Inactive Designation */}
            <div className="lg:col-span-1 bg-[#3A2285] rounded-3xl p-8 shadow-md flex flex-col text-white">
              <div className="flex items-start gap-4 mb-6">
                <div className="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                  <UserX size={20} className="text-white/80" />
                </div>
                <h2 className="text-lg font-bold leading-tight">Inactive<br />Designation</h2>
              </div>

              <p className="text-white/80 text-sm leading-relaxed mb-8">
                A student's status is automatically transitioned to "Inactive" under the following conditions:
              </p>

              <ul className="flex flex-col gap-6 mt-auto">
                <li className="flex items-start gap-4">
                  <div className="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-white/70">
                    01
                  </div>
                  <p className="text-xs text-white/90 leading-relaxed pt-0.5">
                    Failure to report back to the university upon the expiration of an approved academic leave.
                  </p>
                </li>
                <li className="flex items-start gap-4">
                  <div className="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-white/70">
                    02
                  </div>
                  <p className="text-xs text-white/90 leading-relaxed pt-0.5">
                    Failure to complete the course enrollment process within the officially designated university timelines.
                  </p>
                </li>
              </ul>
            </div>
          </div>

          {/* Bottom Card: Re-instatement Protocols */}
          <div className="bg-[#F8F9FB] border border-gray-100 rounded-3xl p-8 shadow-sm">
            <div className="flex flex-col md:flex-row gap-8 items-center md:items-stretch">

              <div className="relative w-full md:w-1/3 aspect-square rounded-2xl overflow-hidden shadow-inner flex-shrink-0">
                <Image src="/image.png" alt="Re-instatement Room" fill sizes="100vw" className="object-cover" />
              </div>

              <div className="flex flex-col justify-center flex-1">
                <h2 className="text-xl font-bold text-gray-900 mb-4">Re-instatement Protocols</h2>
                <p className="text-sm text-gray-600 leading-relaxed mb-8">
                  Returning to active study status requires a formal administrative review. Students must adhere to strict submission deadlines to ensure academic continuity.
                </p>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">

                  <div className="flex flex-col">
                    <h3 className="text-2xl font-bold text-theme-purple-400 mb-1">14 Days</h3>
                    <h4 className="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">PRIOR TO ENROLLMENT</h4>
                    <p className="text-xs text-gray-500 leading-relaxed">
                      Requests for re-instatement must be submitted at least 2 weeks before the start of the enrollment window.
                    </p>
                  </div>

                  <div className="flex flex-col border-l-2 border-gray-200 pl-6">
                    <div className="flex items-center gap-2 mb-3">
                      <FileText size={16} className="text-theme-purple-400" />
                      <h4 className="text-sm font-bold text-gray-900">Required<br />Action</h4>
                    </div>
                    <ul className="flex flex-col gap-2">
                      <li className="flex items-center gap-2 text-xs text-gray-500">
                        <div className="w-1 h-1 rounded-full bg-gray-400"></div> Formal Re-instatement Request Form
                      </li>
                      <li className="flex items-center gap-2 text-xs text-gray-500">
                        <div className="w-1 h-1 rounded-full bg-gray-400"></div> Academic Advising Confirmation
                      </li>
                      <li className="flex items-center gap-2 text-xs text-gray-500">
                        <div className="w-1 h-1 rounded-full bg-gray-400"></div> Clearance from Financial Office
                      </li>
                    </ul>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      )}

      {activeTab === "Judiciary & Graduation Process" && (
        <div className="flex flex-col gap-6">

          {/* Top Section: Mandatory Requirements & Image */}
          <div className="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col md:flex-row gap-8">
            <div className="flex-1 flex flex-col">
              <h2 className="text-xl font-bold text-gray-900 mb-8">Mandatory Requirements</h2>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">
                <div className="flex items-start gap-4">
                  <div className="w-10 h-10 rounded-xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
                    <FileText size={18} />
                  </div>
                  <div className="flex flex-col">
                    <h4 className="text-sm font-bold text-gray-900 mb-1">GPA Threshold</h4>
                    <p className="text-[11px] text-gray-500 leading-relaxed">
                      Minimum cumulative Grade Point Average of <strong className="text-theme-purple-400">2.00</strong> is strictly required.
                    </p>
                  </div>
                </div>

                <div className="flex items-start gap-4">
                  <div className="w-10 h-10 rounded-xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
                    <FileCheck size={18} />
                  </div>
                  <div className="flex flex-col">
                    <h4 className="text-sm font-bold text-gray-900 mb-1">Subject Completion</h4>
                    <p className="text-[11px] text-gray-500 leading-relaxed">
                      Zero tolerance for failed (E) or incomplete (I) subjects in the transcript.
                    </p>
                  </div>
                </div>

                <div className="flex items-start gap-4">
                  <div className="w-10 h-10 rounded-xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
                    <Calendar size={18} />
                  </div>
                  <div className="flex flex-col">
                    <h4 className="text-sm font-bold text-gray-900 mb-1">Leave Allowance</h4>
                    <p className="text-[11px] text-gray-500 leading-relaxed">
                      Maximum of <strong className="text-theme-purple-400 underline decoration-2 underline-offset-2">2 semesters</strong> of academic leave throughout the study period.
                    </p>
                  </div>
                </div>

                <div className="flex items-start gap-4">
                  <div className="w-10 h-10 rounded-xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
                    <Wallet size={18} />
                  </div>
                  <div className="flex flex-col">
                    <h4 className="text-sm font-bold text-gray-900 mb-1">Clear Obligations</h4>
                    <p className="text-[11px] text-gray-500 leading-relaxed">
                      No pending financial dues or unreturned library assets.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div className="w-full md:w-[280px] h-[300px] relative rounded-2xl overflow-hidden shadow-inner flex-shrink-0">
              <Image src="/image.png" alt="Path to Commencement" fill sizes="100vw" className="object-cover" />
              <div className="absolute inset-0 bg-gradient-to-t from-[#27105F] to-[#27105F]/20 mix-blend-multiply"></div>
              <div className="absolute inset-0 p-6 flex flex-col justify-end text-white">
                <span className="w-fit px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-md text-[9px] font-bold uppercase tracking-wider mb-2">
                  Official Guideline
                </span>
                <h3 className="font-bold text-lg leading-tight shadow-sm">
                  The Path to Commencement
                </h3>
              </div>
            </div>
          </div>

          {/* Middle Section: Approval Workflow */}
          <div className="bg-[#F8F9FB] border border-gray-100 rounded-3xl p-10 flex flex-col items-center text-center shadow-sm relative overflow-hidden">
            <h2 className="text-xl font-bold text-gray-900 mb-2">Approval Workflow</h2>
            <p className="text-xs text-gray-500 mb-12">A multi-unit verification process ensuring academic integrity.</p>

            <div className="flex flex-col md:flex-row items-start justify-center gap-8 md:gap-0 w-full max-w-3xl relative z-10">
              {/* Line connecting the steps (visible on md+) */}
              <div className="hidden md:block absolute top-[28px] left-[15%] right-[15%] h-[2px] bg-gray-200 -z-10"></div>

              {/* Step 1 */}
              <div className="flex-1 flex flex-col items-center">
                <div className="w-14 h-14 rounded-2xl bg-white shadow-sm border border-gray-100 text-theme-purple-400 flex items-center justify-center mb-4">
                  <ClipboardCheck size={24} />
                </div>
                <h4 className="text-sm font-bold text-gray-900 mb-1">Study Program</h4>
                <span className="text-[9px] font-bold text-theme-purple-300 uppercase tracking-widest mb-3">Phase 01</span>
                <p className="text-[11px] text-gray-500 px-4 leading-relaxed">
                  Initial validation of credit load and academic eligibility by the Head of Study Program.
                </p>
              </div>

              {/* Step 2 */}
              <div className="flex-1 flex flex-col items-center">
                <div className="w-14 h-14 rounded-2xl bg-white shadow-sm border border-gray-100 text-theme-purple-400 flex items-center justify-center mb-4">
                  <ShieldCheck size={24} />
                </div>
                <h4 className="text-sm font-bold text-gray-900 mb-1">Academic Unit</h4>
                <span className="text-[9px] font-bold text-theme-purple-300 uppercase tracking-widest mb-3">Phase 02</span>
                <p className="text-[11px] text-gray-500 px-4 leading-relaxed">
                  Verification of transcripts, leave records, and cross-checking graduation requirements.
                </p>
              </div>

              {/* Step 3 */}
              <div className="flex-1 flex flex-col items-center">
                <div className="w-14 h-14 rounded-2xl bg-white shadow-sm border border-gray-100 text-theme-purple-400 flex items-center justify-center mb-4">
                  <Banknote size={24} />
                </div>
                <h4 className="text-sm font-bold text-gray-900 mb-1">Finance Unit</h4>
                <span className="text-[9px] font-bold text-theme-purple-300 uppercase tracking-widest mb-3">Phase 03</span>
                <p className="text-[11px] text-gray-500 px-4 leading-relaxed">
                  Final clearance of all financial obligations and administrative processing fees.
                </p>
              </div>
            </div>
          </div>

          {/* Bottom Section: Deadline & CTA */}
          <div className="flex flex-col md:flex-row gap-6">
            <div className="flex-shrink-0 w-full md:w-[280px] bg-[#FFF8F5] border border-red-100 rounded-3xl p-6 shadow-sm flex flex-col items-center text-center justify-center">
              <TriangleAlert size={24} className="text-red-500 mb-3" />
              <h4 className="text-[10px] font-bold text-red-600 uppercase tracking-widest mb-3">Crucial Deadline</h4>
              <p className="text-xs text-gray-800 font-bold leading-relaxed px-2">
                Applications must be submitted 3 months prior to ceremony.
              </p>
            </div>

            <div className="flex-1 bg-[#3A2285] rounded-3xl p-8 shadow-md flex flex-col sm:flex-row items-center justify-between gap-6 text-white">
              <div className="flex flex-col">
                <h2 className="text-lg font-bold mb-2">Ready for Judicium?</h2>
                <p className="text-white/80 text-xs leading-relaxed max-w-sm">
                  Check your personalized graduation dashboard to track your real-time progress against these requirements.
                </p>
              </div>
              <button className="px-6 py-3 bg-white text-theme-purple-400 font-bold text-xs rounded-xl shadow-md hover:bg-gray-50 transition-colors whitespace-nowrap">
                Open Dashboard &rarr;
              </button>
            </div>
          </div>

        </div>
      )}

      {activeTab === "Academic & Status" && (
        <div className="flex flex-col gap-6">
          
          {/* Top Section: Criteria I & II */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {/* Criterion I */}
            <div className="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col relative overflow-hidden">
              <div className="absolute right-0 top-0 opacity-[0.03] pointer-events-none transform translate-x-1/4 -translate-y-1/4">
                <Search size={160} />
              </div>
              <h2 className="text-xl font-bold text-theme-purple-400 mb-4">Criterion I: Initial Progress</h2>
              <p className="text-sm text-gray-600 leading-relaxed mb-10 relative z-10">
                Students who fail to demonstrate adequate academic momentum during their first four semesters are subject to mandatory withdrawal.
              </p>
              <div className="flex items-center justify-between mt-auto">
                <div className="flex flex-col">
                  <span className="text-2xl font-bold text-gray-900">&lt; 30</span>
                  <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Credits<br/>Earned</span>
                </div>
                <div className="flex flex-col">
                  <span className="text-2xl font-bold text-red-500">&lt; 2.00</span>
                  <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Cumulative<br/>GPA</span>
                </div>
                <div className="flex flex-col">
                  <span className="text-2xl font-bold text-gray-900">04</span>
                  <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Semesters<br/>Max</span>
                </div>
              </div>
            </div>

            {/* Criterion II */}
            <div className="bg-[#EEF2FF] border-l-4 border-theme-purple-400 rounded-3xl p-8 shadow-sm flex flex-col">
              <h2 className="text-xl font-bold text-gray-900 mb-4">Criterion II:<br/>Consistent Performance</h2>
              <p className="text-sm text-gray-600 leading-relaxed mb-8">
                Sustained low performance results in immediate review for academic dismissal.
              </p>
              <div className="bg-white rounded-2xl p-6 shadow-sm mt-auto">
                <div className="flex items-center justify-between mb-3">
                  <span className="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Target GPA</span>
                  <span className="px-2 py-1 bg-red-100 text-red-600 text-[9px] font-bold uppercase tracking-wider rounded-md">Critical</span>
                </div>
                <p className="font-bold text-gray-900 text-sm">
                  Cumulative GPA &lt; 2.00 at the end of 3 semesters.
                </p>
              </div>
            </div>

          </div>

          {/* Middle Section: Criterion III */}
          <div className="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col md:flex-row gap-8 items-center">
            <div className="relative w-full md:w-[240px] aspect-square rounded-2xl overflow-hidden shadow-inner flex-shrink-0">
              <Image src="/image.png" alt="Completion Timeframe" fill sizes="100vw" className="object-cover" />
            </div>
            
            <div className="flex flex-col flex-1">
              <h2 className="text-xl font-bold text-gray-900 mb-4">Criterion III: Completion Timeframe</h2>
              <p className="text-sm text-gray-600 leading-relaxed mb-8">
                Degree programs are designed for focused completion. The University enforces a maximum duration limit to ensure currency of knowledge.
              </p>
              
              <div className="flex flex-col sm:flex-row gap-4">
                <div className="bg-[#F0F4FF] rounded-2xl p-5 flex flex-col flex-1">
                  <Calendar size={18} className="text-theme-purple-400 mb-3" />
                  <span className="font-bold text-gray-900 text-lg mb-1">07 Years</span>
                  <span className="text-[10px] text-gray-500">Maximum Calendar Time</span>
                </div>
                <div className="bg-[#F0F4FF] rounded-2xl p-5 flex flex-col flex-1">
                  <Hourglass size={18} className="text-theme-purple-400 mb-3" />
                  <span className="font-bold text-gray-900 text-lg mb-1">14 Semesters</span>
                  <span className="text-[10px] text-gray-500">Maximum Active Enrollment</span>
                </div>
              </div>
            </div>
          </div>

          {/* Table Section */}
          <div className="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
            <div className="overflow-x-auto">
              <table className="w-full text-left border-collapse min-w-[600px]">
                <thead className="bg-[#EBF0FF]">
                  <tr>
                    <th className="py-4 px-6 text-[10px] font-bold text-gray-500 uppercase tracking-widest w-[30%]">Monitoring Point</th>
                    <th className="py-4 px-6 text-[10px] font-bold text-gray-500 uppercase tracking-widest w-[20%]">Min. Credits</th>
                    <th className="py-4 px-6 text-[10px] font-bold text-gray-500 uppercase tracking-widest w-[20%]">Min. GPA</th>
                    <th className="py-4 px-6 text-[10px] font-bold text-gray-500 uppercase tracking-widest w-[30%]">Standing Status</th>
                  </tr>
                </thead>
                <tbody className="text-sm">
                  <tr className="border-b border-gray-50">
                    <td className="py-5 px-6 font-bold text-gray-900">End of 2nd Semester</td>
                    <td className="py-5 px-6 text-gray-600">15 Credits</td>
                    <td className="py-5 px-6 text-gray-600">2.00</td>
                    <td className="py-5 px-6">
                      <span className="px-2.5 py-1 bg-green-100 text-green-700 text-[9px] font-bold uppercase tracking-wider rounded-full">Safe Standing</span>
                    </td>
                  </tr>
                  <tr className="border-b border-gray-50">
                    <td className="py-5 px-6 font-bold text-gray-900">End of 3rd Semester</td>
                    <td className="py-5 px-6 font-bold text-red-500">22 Credits</td>
                    <td className="py-5 px-6 font-bold text-red-500">2.00</td>
                    <td className="py-5 px-6">
                      <span className="px-2.5 py-1 bg-yellow-100 text-yellow-700 text-[9px] font-bold uppercase tracking-wider rounded-full">Warning</span>
                    </td>
                  </tr>
                  <tr>
                    <td className="py-5 px-6 font-bold text-gray-900">End of 4th Semester</td>
                    <td className="py-5 px-6 font-bold text-red-500">30 Credits</td>
                    <td className="py-5 px-6 font-bold text-red-500">2.00</td>
                    <td className="py-5 px-6">
                      <span className="px-2.5 py-1 bg-red-100 text-red-600 text-[9px] font-bold uppercase tracking-wider rounded-full">Dismissal Threshold</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          {/* Appeal Process Section */}
          <div className="bg-[#F4EDFC] rounded-3xl p-8 shadow-sm flex flex-col md:flex-row gap-8">
            <div className="flex-1 flex flex-col">
              <h2 className="text-xl font-bold text-gray-900 mb-4">Appeal Process</h2>
              <p className="text-sm text-gray-600 leading-relaxed mb-8">
                Students facing dismissal have the right to one formal appeal to the Academic Standing Committee. Appeals must be grounded in documented mitigating circumstances (medical, family emergency, or significant personal hardship).
              </p>
              <button className="px-6 py-3 bg-[#3A2285] text-white font-bold text-xs rounded-xl shadow-md hover:bg-[#2c1a65] transition-colors self-start">
                Begin Appeal Submission
              </button>
            </div>
            
            <div className="flex-1 flex flex-col gap-4 justify-center">
              <div className="bg-white rounded-2xl p-4 flex items-center gap-4 shadow-sm">
                <div className="w-10 h-10 rounded-xl bg-theme-purple-100/20 text-theme-purple-400 flex items-center justify-center flex-shrink-0">
                  <UserCheck size={20} />
                </div>
                <div className="flex flex-col">
                  <h4 className="text-sm font-bold text-gray-900">Academic Advising</h4>
                  <p className="text-[10px] text-gray-500">Schedule a mandatory strategy session.</p>
                </div>
              </div>
              <div className="bg-white rounded-2xl p-4 flex items-center gap-4 shadow-sm">
                <div className="w-10 h-10 rounded-xl bg-[#FFF3E0] text-[#E65100] flex items-center justify-center flex-shrink-0">
                  <BookOpen size={20} />
                </div>
                <div className="flex flex-col">
                  <h4 className="text-sm font-bold text-gray-900">Success Resources</h4>
                  <p className="text-[10px] text-gray-500">Access tutoring and time-management workshops.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      )}

      {/* Bottom Callout */}
      <div className="bg-[#F3E8FF] border border-[#E9D5FF] rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm mt-4">
        <div className="flex items-center gap-5">
          <div className="w-12 h-12 rounded-full bg-white text-theme-purple-400 flex items-center justify-center shadow-sm flex-shrink-0">
            <ShieldAlert size={24} />
          </div>
          <div className="flex flex-col">
            <h4 className="font-bold text-gray-900 text-sm">Need clarification?</h4>
            <p className="text-sm text-gray-600 mt-1">The Academic Affairs office is here to help with policy interpretation and exceptions.</p>
          </div>
        </div>
        <div className="flex items-center gap-3 flex-shrink-0">
          <button className="px-5 py-2.5 bg-transparent border border-theme-purple-400 text-theme-purple-400 font-bold text-xs rounded-xl hover:bg-white/50 transition-colors">
            Contact Advisor
          </button>
          <button className="px-5 py-2.5 bg-[#4B1B8A] text-white font-bold text-xs rounded-xl shadow-md hover:bg-[#3d1573] transition-colors">
            Submit Petition
          </button>
        </div>
      </div>

    </div>
  );
}
