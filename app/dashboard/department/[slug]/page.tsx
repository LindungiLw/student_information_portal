import Image from "next/image";
import Link from "next/link";
import { 
  Building, 
  MapPin, 
  Phone, 
  Clock, 
  Mail, 
  Target, 
  Lightbulb, 
  GraduationCap, 
  BarChart, 
  TrendingUp, 
  BookOpen, 
  User, 
  MonitorPlay, 
  FlaskConical, 
  Award,
  Users,
  Box,
  ChevronRight
} from "lucide-react";

export default async function DepartmentDetailPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  
  const departmentNames: Record<string, string> = {
    "english-literature": "English Literature",
    "japanese-literature": "Japanese Literature",
    "accounting": "Accounting",
    "visual-communication-design": "Visual Communication Design",
    "information-systems": "Information Systems",
    "information-technology": "Information Technology"
  };
  
  const departmentName = departmentNames[slug] || "Department Details";

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
        <Building size={18} className="text-gray-400" />
        <Link href="/dashboard/department" className="text-sm font-semibold text-gray-400 hover:text-gray-600 transition-colors">
          Department
        </Link>
        <span className="text-gray-400 text-sm">/</span>
        <span className="text-sm font-semibold text-gray-600">{departmentName}</span>
      </div>

      {/* Title Card */}
      <div className="bg-[#3A2285] rounded-3xl p-10 shadow-md text-white">
        <h1 className="text-3xl font-bold mb-4">{departmentName}</h1>
        <p className="text-white/80 text-sm leading-relaxed max-w-2xl mb-8">
          Bridging the gap between cutting-edge technology and strategic business solutions. Empowering the next generation of digital leaders.
        </p>
        <button className="px-5 py-2.5 bg-white text-theme-purple-400 font-bold text-xs rounded-xl shadow-sm hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
          Explore Program <ChevronRight size={16} />
        </button>
      </div>

      {/* Department Leadership */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center gap-2 text-theme-purple-400">
          <User size={18} />
          <h2 className="text-sm font-bold text-gray-900">Department Leadership</h2>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="md:col-span-2 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col sm:flex-row gap-6 items-start">
            <div className="relative w-24 h-24 rounded-2xl overflow-hidden bg-gray-200 flex-shrink-0">
              <Image src="/image.png" alt="Head of Department" fill sizes="100vw" className="object-cover" />
            </div>
            <div className="flex flex-col flex-1">
              <h3 className="font-bold text-gray-900 text-lg">Name of the Department Head</h3>
              <p className="text-[10px] font-bold text-theme-purple-400 uppercase tracking-widest mb-3">Head of Department</p>
              <p className="text-xs text-gray-500 leading-relaxed mb-4">
                With over 20 years of experience in enterprise systems and digital transformation, Dr. Name leads the department with a vision for integrating cutting-edge tech solutions into business practices.
              </p>
              <button className="px-4 py-2 bg-[#F3E8FF] text-theme-purple-400 font-bold text-[10px] rounded-lg hover:bg-[#e9d5ff] transition-colors self-start inline-flex items-center gap-2">
                <Mail size={14} /> Contact Head
              </button>
            </div>
          </div>
          
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col gap-5">
            <div className="flex items-center gap-2 text-theme-purple-400 mb-1">
              <MapPin size={16} />
              <h3 className="text-sm font-bold text-gray-900">Contact Details</h3>
            </div>
            
            <div className="flex items-start gap-3">
              <MapPin size={14} className="text-gray-400 mt-0.5" />
              <div className="flex flex-col">
                <span className="text-xs font-bold text-gray-900">Location</span>
                <span className="text-[11px] text-gray-500">Building A, 4th Floor</span>
              </div>
            </div>
            
            <div className="flex items-start gap-3">
              <Phone size={14} className="text-gray-400 mt-0.5" />
              <div className="flex flex-col">
                <span className="text-xs font-bold text-gray-900">Phone</span>
                <span className="text-[11px] text-gray-500">+62 21 123 456</span>
              </div>
            </div>
            
            <div className="flex items-start gap-3">
              <Clock size={14} className="text-gray-400 mt-0.5" />
              <div className="flex flex-col">
                <span className="text-xs font-bold text-gray-900">Office Hours</span>
                <span className="text-[11px] text-gray-500">Mon - Fri: 8:00 AM - 4:00 PM</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Vision & Mission */}
      <div className="bg-[#3A2285] rounded-3xl p-10 shadow-md text-white flex flex-col md:flex-row gap-10">
        <div className="flex-1 flex flex-col">
          <div className="flex items-center gap-2 mb-6">
            <Lightbulb size={20} className="text-white/80" />
            <h2 className="text-lg font-bold">Vision & Mission</h2>
          </div>
          
          <h3 className="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-3">Our Vision</h3>
          <p className="text-sm text-white/90 leading-relaxed">
            "To be a global leader in information systems education, empowering digital leaders who bridge the gap between human ingenuity and technological advancement."
          </p>
        </div>
        
        <div className="flex-1 flex flex-col">
          <div className="h-[28px] hidden md:block"></div> {/* Spacer for alignment */}
          <h3 className="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-3">Our Mission</h3>
          <ul className="flex flex-col gap-3">
            <li className="flex items-start gap-2">
              <Target size={14} className="text-white/60 mt-1 flex-shrink-0" />
              <p className="text-sm text-white/90 leading-relaxed">Provide industry-aligned technical and business curriculum.</p>
            </li>
            <li className="flex items-start gap-2">
              <Target size={14} className="text-white/60 mt-1 flex-shrink-0" />
              <p className="text-sm text-white/90 leading-relaxed">Foster an environment of innovation and ethical leadership.</p>
            </li>
          </ul>
        </div>
      </div>

      {/* Degree Requirements */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center gap-2 text-theme-purple-400">
          <GraduationCap size={18} />
          <h2 className="text-sm font-bold text-gray-900">Degree Requirements</h2>
        </div>
        
        <div className="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div className="flex items-end gap-3">
              <span className="text-4xl font-bold text-gray-900 leading-none">144</span>
              <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Total Credits<br/>Required</span>
            </div>
            <div className="flex items-center gap-2">
              <span className="px-3 py-1.5 bg-[#F3E8FF] text-theme-purple-400 text-[10px] font-bold rounded-lg border border-theme-purple-100">GPA &ge; 2.00</span>
              <span className="px-3 py-1.5 bg-[#F3E8FF] text-theme-purple-400 text-[10px] font-bold rounded-lg border border-theme-purple-100">Internship Required</span>
            </div>
          </div>
          
          <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-6 border-t border-gray-100">
            <div className="flex flex-col">
              <h4 className="text-xs font-bold text-gray-900 mb-2">Core IT Courses</h4>
              <p className="text-[11px] text-gray-500 leading-relaxed">Focus on programming, data structures, and algorithms.</p>
            </div>
            <div className="flex flex-col">
              <h4 className="text-xs font-bold text-gray-900 mb-2">Business Foundation</h4>
              <p className="text-[11px] text-gray-500 leading-relaxed">Principles of accounting, finance, and management.</p>
            </div>
            <div className="flex flex-col">
              <h4 className="text-xs font-bold text-gray-900 mb-2">General Education</h4>
              <p className="text-[11px] text-gray-500 leading-relaxed">Humanities, ethics, and communication skills.</p>
            </div>
          </div>
        </div>
      </div>

      {/* Academic Programs */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center gap-2 text-theme-purple-400">
          <BookOpen size={18} />
          <h2 className="text-sm font-bold text-gray-900">Academic Programs</h2>
        </div>
        
        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col">
            <div className="w-10 h-10 rounded-xl bg-[#F3E8FF] text-theme-purple-400 flex items-center justify-center mb-4">
              <BarChart size={20} />
            </div>
            <h3 className="font-bold text-gray-900 mb-2">Data Analytics</h3>
            <p className="text-[11px] text-gray-500 leading-relaxed mb-6 flex-1">
              Master the art of extracting insights from complex datasets to drive organizational decision-making.
            </p>
            <button className="text-[10px] font-bold text-theme-purple-400 hover:underline self-start">
              Learn More &rarr;
            </button>
          </div>
          
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col">
            <div className="w-10 h-10 rounded-xl bg-[#F3E8FF] text-theme-purple-400 flex items-center justify-center mb-4">
              <TrendingUp size={20} />
            </div>
            <h3 className="font-bold text-gray-900 mb-2">Business Intelligence</h3>
            <p className="text-[11px] text-gray-500 leading-relaxed mb-6 flex-1">
              Strategic application of technology and data analysis to provide actionable business intelligence.
            </p>
            <button className="text-[10px] font-bold text-theme-purple-400 hover:underline self-start">
              Learn More &rarr;
            </button>
          </div>
        </div>
      </div>

      {/* Curriculum */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center gap-2 text-theme-purple-400">
          <Box size={18} />
          <h2 className="text-sm font-bold text-gray-900">Curriculum</h2>
        </div>
        
        <div className="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse min-w-[500px]">
              <thead className="bg-[#F8F9FB]">
                <tr>
                  <th className="py-4 px-6 text-[9px] font-bold text-gray-500 uppercase tracking-widest w-[20%]">Year</th>
                  <th className="py-4 px-6 text-[9px] font-bold text-gray-500 uppercase tracking-widest w-[50%]">Core Subjects</th>
                  <th className="py-4 px-6 text-[9px] font-bold text-gray-500 uppercase tracking-widest w-[30%]">Major Skills</th>
                </tr>
              </thead>
              <tbody className="text-xs">
                <tr className="border-b border-gray-50">
                  <td className="py-4 px-6 font-bold text-gray-900">Year 1 & 2</td>
                  <td className="py-4 px-6 text-gray-600">Data Structures, Database Systems</td>
                  <td className="py-4 px-6 text-gray-500">Foundations</td>
                </tr>
                <tr className="border-b border-gray-50">
                  <td className="py-4 px-6 font-bold text-gray-900">Year 3</td>
                  <td className="py-4 px-6 text-gray-600">Systems Analysis, Network Security</td>
                  <td className="py-4 px-6 text-gray-500">Implementation</td>
                </tr>
                <tr>
                  <td className="py-4 px-6 font-bold text-gray-900">Year 4</td>
                  <td className="py-4 px-6 text-gray-600">IT Strategy, Capstone Project</td>
                  <td className="py-4 px-6 text-gray-500">Leadership</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {/* Academic Advisors & Faculty */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center gap-2 text-theme-purple-400">
          <Users size={18} />
          <h2 className="text-sm font-bold text-gray-900">Academic Advisors & Faculty</h2>
        </div>
        
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          {[
            { name: "Prof. Sarah Jenkins", role: "Database Administration" },
            { name: "Dr. Michael Chen", role: "Machine Learning" },
            { name: "Dr. Elena Rodriguez", role: "System Analysis" },
            { name: "Prof. James Wilson", role: "Cybersecurity" }
          ].map((faculty, idx) => (
            <div key={idx} className="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm flex items-center gap-3">
              <div className="w-10 h-10 rounded-full bg-gray-200 overflow-hidden relative flex-shrink-0">
                <Image src="/image.png" alt={faculty.name} fill sizes="100vw" className="object-cover" />
              </div>
              <div className="flex flex-col overflow-hidden">
                <h4 className="text-xs font-bold text-gray-900 truncate">{faculty.name}</h4>
                <p className="text-[9px] text-gray-500 truncate">{faculty.role}</p>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Additional Programs & Resources */}
      <div className="flex flex-col gap-4">
        <div className="flex items-center gap-2 text-theme-purple-400">
          <Award size={18} />
          <h2 className="text-sm font-bold text-gray-900">Additional Programs & Resources</h2>
        </div>
        
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col items-start text-left">
            <MonitorPlay size={24} className="text-theme-purple-400 mb-4" />
            <h4 className="text-xs font-bold text-gray-900 mb-2">Advanced IT Lab</h4>
            <p className="text-[10px] text-gray-500 leading-relaxed">State-of-the-art facilities for high-performance computing and client-server environments.</p>
          </div>
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col items-start text-left">
            <FlaskConical size={24} className="text-theme-purple-400 mb-4" />
            <h4 className="text-xs font-bold text-gray-900 mb-2">Research Centers</h4>
            <p className="text-[10px] text-gray-500 leading-relaxed">Collaborative hubs focused on AI, data analytics, and cybersecurity research.</p>
          </div>
          <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col items-start text-left">
            <Award size={24} className="text-theme-purple-400 mb-4" />
            <h4 className="text-xs font-bold text-gray-900 mb-2">Specialized Certifications</h4>
            <p className="text-[10px] text-gray-500 leading-relaxed">In-house training for AWS, Cisco, and Microsoft professional certificates.</p>
          </div>
        </div>
      </div>

    </div>
  );
}
