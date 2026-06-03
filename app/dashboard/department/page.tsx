import Image from "next/image";
import Link from "next/link";
import { Building, BookText, Briefcase, Palette, MonitorSmartphone, Cpu } from "lucide-react";

export default function DepartmentPage() {
  const departments = [
    {
      slug: "english-literature",
      category: "HUMANITIES",
      icon: <BookText size={14} />,
      title: "English Literature",
      desc: "Dive into the rich tapestry of classical and modern literary works from around the globe.",
    },
    {
      slug: "japanese-literature",
      category: "HUMANITIES",
      icon: <BookText size={14} />,
      title: "Japanese Literature",
      desc: "Master the Japanese language and its profound cultural heritage through historical and contemporary texts.",
    },
    {
      slug: "accounting",
      category: "BUSINESS",
      icon: <Briefcase size={14} />,
      title: "Accounting",
      desc: "Gain a profound education in financial reporting, auditing, strategic taxation, and corporate governance.",
    },
    {
      slug: "visual-communication-design",
      category: "CREATIVE ARTS",
      icon: <Palette size={14} />,
      title: "Visual Communication Design",
      desc: "Develop creative solutions through visual storytelling, branding, and human-centered design systems.",
    },
    {
      slug: "information-systems",
      category: "TECHNOLOGY & BUSINESS",
      icon: <MonitorSmartphone size={14} />,
      title: "Information Systems",
      desc: "Bridge the gap between organizational processes and complex technical software solutions.",
    },
    {
      slug: "information-technology",
      category: "ENGINEERING",
      icon: <Cpu size={14} />,
      title: "Information Technology",
      desc: "Engineering the digital future through software development, network infrastructure, and cybersecurity.",
    }
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
        <Building size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">Department</span>
      </div>

      {/* Header */}
      <div className="flex flex-col gap-3">
        <h1 className="text-2xl font-bold text-gray-900">Our Academic Departments</h1>
        <p className="text-sm text-gray-600 leading-relaxed max-w-3xl">
          Explore diverse learning opportunities across our specialized faculties. From the humanities to advanced engineering, our departments are designed to foster innovation, critical thinking, and professional excellence.
        </p>
      </div>

      {/* Departments Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        {departments.map((dept, idx) => (
          <div key={idx} className="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm flex flex-col hover:shadow-md transition-shadow">
            
            {/* Image Placeholder */}
            <div className="relative w-full h-[180px]">
              <Image src="/image.png" alt={dept.title} fill sizes="100vw" className="object-cover" />
            </div>
            
            {/* Content */}
            <div className="p-6 flex flex-col flex-1">
              <div className="flex items-center gap-2 text-theme-purple-400 mb-3">
                {dept.icon}
                <span className="text-[10px] font-bold uppercase tracking-widest">{dept.category}</span>
              </div>
              
              <h3 className="text-lg font-bold text-gray-900 mb-3 leading-tight">{dept.title}</h3>
              <p className="text-xs text-gray-500 leading-relaxed mb-6 flex-1">
                {dept.desc}
              </p>
              
              <Link href={`/dashboard/department/${dept.slug}`} className="w-full py-3 bg-theme-purple-100/30 text-theme-purple-400 font-bold text-[11px] rounded-xl hover:bg-theme-purple-100/50 transition-colors flex items-center justify-center gap-1">
                View Department <span>&rarr;</span>
              </Link>
            </div>
            
          </div>
        ))}
      </div>

    </div>
  );
}
