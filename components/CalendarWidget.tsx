"use client";

import { useState } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

const MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// Mock events to display dots on the calendar
// Types match the color guide: exams (purple), events (blue), announcements (yellow), holiday (red)
const MOCK_EVENTS = [
  { date: '2024-10-14', type: 'exams' },
  { date: '2024-10-18', type: 'events' },
  { date: '2024-10-25', type: 'exams' },
  { date: '2024-11-05', type: 'announcements' },
  { date: '2024-11-12', type: 'exams' },
  { date: '2024-11-20', type: 'holiday' },
];

export default function CalendarWidget() {
  // Start with October 2024 to match the design initially
  const [currentDate, setCurrentDate] = useState(new Date(2024, 9, 1)); 

  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  const handlePrevMonth = () => setCurrentDate(new Date(year, month - 1, 1));
  const handleNextMonth = () => setCurrentDate(new Date(year, month + 1, 1));

  const firstDayOfMonth = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const daysInPrevMonth = new Date(year, month, 0).getDate();

  const currentMonthEvents = MOCK_EVENTS.filter(e => {
    const eventDate = new Date(e.date);
    return eventDate.getFullYear() === year && eventDate.getMonth() === month;
  });

  const renderCells = () => {
    const cells = [];
    
    // Previous month padding
    for (let i = firstDayOfMonth - 1; i >= 0; i--) {
      cells.push(<div key={`prev-${i}`} className="text-gray-300 flex items-center justify-center w-7 h-7 mx-auto">{daysInPrevMonth - i}</div>);
    }
    
    // Current month days
    for (let i = 1; i <= daysInMonth; i++) {
      const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
      const event = MOCK_EVENTS.find(e => e.date === dateStr);
      
      if (event) {
        let bgClass = "";
        if (event.type === 'exams') bgClass = 'bg-theme-purple-100/20 text-theme-purple-400';
        else if (event.type === 'events') bgClass = 'bg-theme-blue-100/20 text-theme-blue-300';
        else if (event.type === 'announcements') bgClass = 'bg-theme-yellow-400/20 text-theme-yellow-400';
        else if (event.type === 'holiday') bgClass = 'bg-red-500/10 text-red-500';

        cells.push(
          <div key={`cur-${i}`} className={`relative w-7 h-7 mx-auto flex items-center justify-center rounded-full font-bold ${bgClass}`}>
            {i}
          </div>
        );
      } else {
        const isToday = new Date().toDateString() === new Date(year, month, i).toDateString();
        cells.push(
          <div key={`cur-${i}`} className={`flex items-center justify-center w-7 h-7 mx-auto ${isToday ? 'bg-gray-100 rounded-full font-bold text-gray-900' : ''}`}>
            {i}
          </div>
        );
      }
    }
    
    // Next month padding (ensure 6 rows = 42 cells total for consistent height)
    const remainingCells = 42 - cells.length; 
    for (let i = 1; i <= remainingCells; i++) {
      cells.push(<div key={`next-${i}`} className="text-gray-300 flex items-center justify-center w-7 h-7 mx-auto">{i}</div>);
    }
    return cells;
  };

  return (
    <div className="bg-white border border-gray-100 rounded-3xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] w-full">
      <div className="flex items-center justify-between mb-6">
        <h3 className="text-[13px] font-bold text-gray-800 uppercase tracking-wide">
          {MONTHS[month]} {year}
        </h3>
        <div className="flex gap-2 text-gray-400">
          <button onClick={handlePrevMonth} className="hover:text-gray-800 transition-colors p-1"><ChevronLeft size={16} /></button>
          <button onClick={handleNextMonth} className="hover:text-gray-800 transition-colors p-1"><ChevronRight size={16} /></button>
        </div>
      </div>
      
      <div className="grid grid-cols-7 text-center mb-4 text-[11px] font-bold text-gray-400">
        <div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div>
      </div>
      
      <div className="grid grid-cols-7 gap-y-3 text-center text-xs font-semibold text-gray-800">
        {renderCells()}
      </div>
      
      <div className="mt-8 pt-4 border-t border-gray-100 text-[11px] text-gray-400 font-medium">
        {currentMonthEvents.length} events scheduled for this month.
      </div>
    </div>
  );
}
