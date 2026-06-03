"use client";

import { useState } from "react";
import Image from "next/image";
import { 
  CreditCard, 
  ChevronDown, 
  ChevronUp, 
  Globe, 
  Banknote,
  Headset
} from "lucide-react";

export default function FinancePage() {
  const [activeTab, setActiveTab] = useState("Domestic Students");
  const [expandedFaq, setExpandedFaq] = useState<number | null>(0);

  const toggleFaq = (index: number) => {
    if (expandedFaq === index) {
      setExpandedFaq(null);
    } else {
      setExpandedFaq(index);
    }
  };

  const faqs = [
    {
      q: "When is the final deadline for fall semester tuition?",
      a: "The final deadline for all outstanding Fall 2023 balances is October 15th. Late fees of $150 will be applied thereafter."
    },
    {
      q: "How do I set up a monthly payment plan?",
      a: "You can set up a monthly payment plan through the SIMAK portal under the 'Billing' section."
    },
    {
      q: "My scholarship isn't appearing on my statement.",
      a: "Please allow 3-5 business days for scholarships to reflect. Contact the financial aid office if it persists."
    }
  ];

  return (
    <div className="max-w-[1000px] mx-auto w-full flex flex-col gap-8 pb-10">
      
      {/* Hero Section */}
      <div className="relative w-full h-[200px] rounded-[20px] overflow-hidden shadow-sm">
        <Image
          src="/image.png"
          alt="Campus Banner"
          fill
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
      <div className="w-full bg-[#E5E7EB] rounded-xl py-3.5 px-5 flex items-center gap-3 text-gray-500 shadow-sm border border-gray-100">
        <CreditCard size={18} className="text-gray-400" />
        <span className="text-sm font-semibold text-gray-600">Cost of Attendance</span>
      </div>

      {/* Tabs */}
      <div className="flex items-center gap-8 border-b border-gray-200">
        {["Domestic Students", "International Student"].map((tab) => (
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

      {/* Dynamic Content based on Tab */}
      {activeTab === "Domestic Students" && (
        <div className="flex flex-col gap-10">
          
          {/* Tuition & Fees Section */}
          <div className="flex flex-col gap-4">
            <h2 className="text-lg font-bold text-gray-900">Domestic Student Tuition & Fees</h2>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {/* Term Fees */}
              <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col">
                <h3 className="text-[10px] font-bold text-theme-purple-400 uppercase tracking-widest mb-4">Term Fees</h3>
                
                <div className="flex flex-col gap-3">
                  <div className="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                    <span className="text-gray-500">Tuition (EL/JL/ACC)</span>
                    <span className="font-bold text-gray-900">Rp. 12,500,000</span>
                  </div>
                  <div className="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                    <span className="text-gray-500">Tuition (IT/IS/VCD)</span>
                    <span className="font-bold text-gray-900">Rp. 15,000,000</span>
                  </div>
                  <div className="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                    <span className="text-gray-500">Dorm Fee (Monthly)</span>
                    <span className="font-bold text-gray-900">Rp. 2,800,000</span>
                  </div>
                  <div className="flex items-center justify-between py-2 text-sm">
                    <span className="text-gray-500">Meal Fee (Monthly)</span>
                    <span className="font-bold text-gray-900">Rp. 2,400,000</span>
                  </div>
                </div>
              </div>
              
              {/* One-Time Enrollment Fees */}
              <div className="bg-[#F4EDFC] rounded-3xl p-6 shadow-sm flex flex-col">
                <div className="flex items-center gap-2 mb-4">
                  <span className="text-[10px] font-bold text-theme-purple-400 uppercase tracking-widest">One-Time Enrollment Fees</span>
                </div>
                
                <div className="flex flex-col gap-3">
                  <div className="flex items-center justify-between py-2 border-b border-theme-purple-100/50 text-sm">
                    <span className="text-gray-600">Registration Fee</span>
                    <span className="font-bold text-gray-900">Rp. 300,000</span>
                  </div>
                  <div className="flex items-center justify-between py-2 border-b border-theme-purple-100/50 text-sm">
                    <span className="text-gray-600">Development Fee</span>
                    <span className="font-bold text-gray-900">Rp. 10,000,000</span>
                  </div>
                  <div className="flex items-center justify-between py-2 text-sm">
                    <span className="text-gray-600">Matriculation Fee</span>
                    <span className="font-bold text-gray-900">Rp. 3,000,000</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Payment Rules Section */}
          <div className="flex flex-col gap-4">
            <h2 className="text-lg font-bold text-gray-900">Payment Rules & Installments</h2>
            
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div className="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-theme-purple-400 flex flex-col">
                <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Enrollment</span>
                <div className="flex items-baseline gap-2">
                  <span className="text-3xl font-bold text-gray-900">25%</span>
                </div>
                <span className="text-[10px] text-gray-400 mt-1">of total bill required</span>
              </div>
              <div className="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-theme-purple-400 flex flex-col">
                <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Midterm</span>
                <div className="flex items-baseline gap-2">
                  <span className="text-3xl font-bold text-gray-900">50%</span>
                </div>
                <span className="text-[10px] text-gray-400 mt-1">of total bill required</span>
              </div>
              <div className="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-theme-purple-400 flex flex-col">
                <span className="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Final Exam</span>
                <div className="flex items-baseline gap-2">
                  <span className="text-3xl font-bold text-gray-900">100%</span>
                </div>
                <span className="text-[10px] text-gray-400 mt-1">of total bill required</span>
              </div>
            </div>
            
            <div className="bg-white border border-gray-100 rounded-2xl p-5 mt-2">
              <span className="text-xs font-bold text-gray-900 mb-2 block">Note</span>
              <ul className="text-[11px] text-gray-500 flex flex-col gap-1.5 list-disc pl-4">
                <li>As a requirement for Enrollment, students are required to pay 25% of the total bill</li>
                <li>As a requirement for Midterm, students are required to pay 50% of the total bill</li>
                <li>As a requirement for Final Exam, students are required to pay 100% of the total bill</li>
              </ul>
            </div>
          </div>

        </div>
      )}

      {/* International Student Content */}
      {activeTab === "International Student" && (
        <div className="flex flex-col gap-8">
          
          <div className="flex flex-col gap-4">
            <h2 className="text-lg font-bold text-gray-900">International Student Fees</h2>
            
            <div className="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
              <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse min-w-[600px]">
                  <thead className="bg-[#4B1B8A] text-white">
                    <tr>
                      <th className="py-4 px-6 text-[10px] font-bold uppercase tracking-widest w-[30%]">Category</th>
                      <th className="py-4 px-6 text-[10px] font-bold uppercase tracking-widest w-[35%]">In State [Approx.]</th>
                      <th className="py-4 px-6 text-[10px] font-bold uppercase tracking-widest w-[35%]">Out of State</th>
                    </tr>
                  </thead>
                  <tbody className="text-xs">
                    <tr className="border-b border-gray-50">
                      <td className="py-4 px-6 font-medium text-gray-900">Registration</td>
                      <td className="py-4 px-6 text-gray-600">$18.75 / Rp 300k</td>
                      <td className="py-4 px-6 font-bold text-theme-purple-400">$30 / Rp 480k</td>
                    </tr>
                    <tr className="border-b border-gray-50">
                      <td className="py-4 px-6 font-medium text-gray-900">Development</td>
                      <td className="py-4 px-6 text-gray-600">$625 / Rp 10M</td>
                      <td className="py-4 px-6 font-bold text-theme-purple-400">$1,000 / Rp 16M</td>
                    </tr>
                    <tr className="border-b border-gray-50">
                      <td className="py-4 px-6 font-medium text-gray-900">Matriculation</td>
                      <td className="py-4 px-6 text-gray-600">$187.5 / Rp 3M</td>
                      <td className="py-4 px-6 font-bold text-theme-purple-400">$300 / Rp 4.8M</td>
                    </tr>
                    <tr className="border-b border-gray-50">
                      <td className="py-4 px-6 font-medium text-gray-900">Tuition</td>
                      <td className="py-4 px-6 text-gray-600">$937.5 / Rp 15M</td>
                      <td className="py-4 px-6 font-bold text-theme-purple-400">$1,500 / Rp 24M</td>
                    </tr>
                    <tr className="border-b border-gray-50">
                      <td className="py-4 px-6 font-medium text-gray-900">Dormitory</td>
                      <td className="py-4 px-6 text-gray-600">$262.5 / Rp 4.2M</td>
                      <td className="py-4 px-6 font-bold text-theme-purple-400">$420 / Rp 6.72M</td>
                    </tr>
                    <tr>
                      <td className="py-4 px-6 font-medium text-gray-900">Meal</td>
                      <td className="py-4 px-6 text-gray-600">$225 / Rp 3.6M</td>
                      <td className="py-4 px-6 font-bold text-theme-purple-400">$250 / Rp 4M</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div className="bg-[#FFFDF0] border border-[#FDE68A] rounded-2xl p-4 shadow-sm flex items-start gap-3 mt-2">
              <div className="w-5 h-5 rounded-full border border-orange-400 flex items-center justify-center flex-shrink-0 text-orange-500 font-bold text-xs">
                !
              </div>
              <div className="flex flex-col">
                <h4 className="text-xs font-bold text-gray-900">Additional Visa Costs</h4>
                <p className="text-[11px] text-orange-600 mt-0.5">$650 application fee, $650 extension (required every 2 years).</p>
              </div>
            </div>

            <div className="bg-gray-50 border border-gray-100 rounded-2xl p-6 mt-4">
              <span className="text-xs font-bold text-gray-900 mb-3 block">Note</span>
              <ul className="text-[10px] text-gray-500 flex flex-col gap-1.5 list-disc pl-4">
                <li>Exchange Rate: 1 USD = 16,000 IDR (subject to change based on current exchange rate).</li>
                <li>The listed tuition fees apply only to the following programs: Information Technology, Information Systems, and Visual Communication Design.<br/>
                For English Literature, Japanese Literature, and Accounting:<br/>
                &nbsp;&nbsp;&nbsp;(*) Out-of-State tuition is USD 1,200<br/>
                &nbsp;&nbsp;&nbsp;(*) In-State tuition is IDR 12,000,000</li>
                <li>Fees in <i className="italic">italic</i> are charged only in Semester 1.</li>
                <li>Fees in <b className="font-bold text-gray-700">bold</b> are charged every semester.</li>
                <li>The highlighted column shows the amount as displayed on the official website and promotional materials. The non-highlighted column presents the converted value for reference purposes only.</li>
                <li>Additional visa cost applies (USD 650 for visa application, USD 650 for visa extension every 2 years).</li>
              </ul>
            </div>
            
          </div>
        </div>
      )}

      {/* Shared FAQ & Payment Methods Section */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
        <div className="lg:col-span-2 flex flex-col gap-4">
          <h2 className="text-lg font-bold text-gray-900">Frequently Asked Questions</h2>
          <div className="flex flex-col gap-3">
            {faqs.map((faq, index) => (
              <div key={index} className="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                <button 
                  onClick={() => toggleFaq(index)}
                  className="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors"
                >
                  <span className="text-xs font-bold text-gray-900">{faq.q}</span>
                  {expandedFaq === index ? (
                    <ChevronUp size={16} className="text-theme-purple-400 flex-shrink-0" />
                  ) : (
                    <ChevronDown size={16} className="text-theme-purple-400 flex-shrink-0" />
                  )}
                </button>
                {expandedFaq === index && (
                  <div className="p-4 pt-0 text-[11px] text-gray-500 leading-relaxed border-t border-gray-50 mt-1">
                    {faq.a}
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
        
        <div className="flex flex-col gap-4">
          <h2 className="text-lg font-bold text-gray-900">Payment Methods</h2>
          <div className="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm flex flex-col gap-4">
            <div className="flex items-start gap-4 border-b border-gray-50 pb-4">
              <div className="w-10 h-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center flex-shrink-0 text-gray-600">
                <Globe size={18} />
              </div>
              <div className="flex flex-col mt-0.5">
                <h4 className="text-xs font-bold text-gray-900">Online Payment</h4>
                <p className="text-[10px] text-gray-500 mt-1">Virtual Account via SIMAK (website/app)</p>
              </div>
            </div>
            
            <div className="flex items-start gap-4">
              <div className="w-10 h-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center flex-shrink-0 text-gray-600">
                <Banknote size={18} />
              </div>
              <div className="flex flex-col mt-0.5">
                <h4 className="text-xs font-bold text-gray-900">Offline Payment</h4>
                <p className="text-[10px] text-gray-500 mt-1">Cash at JIU Finance Department</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/* Bottom Contact */}
      <div className="mt-8 flex flex-col items-center gap-3">
        <span className="text-[11px] text-gray-500">Need help with your payments?</span>
        <button className="px-6 py-3 bg-[#3A2285] text-white font-bold text-xs rounded-xl shadow-md hover:bg-[#2c1a65] transition-colors flex items-center gap-2">
          <Headset size={16} /> Contact Finance Dept
        </button>
      </div>

    </div>
  );
}
