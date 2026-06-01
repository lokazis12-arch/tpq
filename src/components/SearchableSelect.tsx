'use client';

import { useState, useRef, useEffect } from 'react';

interface Option {
  id: string | number;
  name: string;
  class?: string;
}

interface SearchableSelectProps {
  options: Option[];
  placeholder?: string;
  name: string;
  required?: boolean;
  defaultValue?: string | number;
  onSelect?: (value: string | number) => void;
}

export default function SearchableSelect({
  options,
  placeholder = '-- Pilih Santri --',
  name,
  required = false,
  defaultValue = '',
  onSelect
}: SearchableSelectProps) {
  const [isOpen, setIsOpen] = useState(false);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedValue, setSelectedValue] = useState<string | number>(defaultValue);
  const [selectedLabel, setSelectedLabel] = useState('');

  const containerRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (defaultValue) {
      const option = options.find(o => String(o.id) === String(defaultValue));
      if (option) {
        setSelectedValue(defaultValue);
        setSelectedLabel(option.class ? `${option.name} (${option.class})` : option.name);
      }
    } else {
      setSelectedValue('');
      setSelectedLabel('');
    }
  }, [defaultValue, options]);

  // Close dropdown on click outside
  useEffect(() => {
    function handleClickOutside(event: MouseEvent) {
      if (containerRef.current && !containerRef.current.contains(event.target as Node)) {
        setIsOpen(false);
        setSearchTerm('');
      }
    }
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  const filteredOptions = options.filter(option =>
    option.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    (option.class && option.class.toLowerCase().includes(searchTerm.toLowerCase()))
  );

  const handleSelect = (option: Option) => {
    setSelectedValue(option.id);
    const label = option.class ? `${option.name} (${option.class})` : option.name;
    setSelectedLabel(label);
    setSearchTerm('');
    setIsOpen(false);
    if (onSelect) {
      onSelect(option.id);
    }
  };

  const handleClear = (e: React.MouseEvent) => {
    e.stopPropagation();
    setSelectedValue('');
    setSelectedLabel('');
    setSearchTerm('');
    setIsOpen(false);
    if (onSelect) {
      onSelect('');
    }
  };

  return (
    <div className="relative w-full" ref={containerRef}>
      {/* Hidden input to pass value in standard HTML forms */}
      <input type="hidden" name={name} value={selectedValue} required={required} />
      
      <div 
        onClick={() => setIsOpen(!isOpen)}
        className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus-within:ring-2 focus-within:ring-primary focus-within:border-primary outline-none bg-white flex justify-between items-center cursor-pointer min-h-[50px] transition-all"
      >
        <div className="flex-grow pr-2">
          {isOpen ? (
            <input
              type="text"
              className="w-full outline-none text-slate-900 bg-transparent placeholder-gray-400 border-none p-0 focus:ring-0"
              placeholder="Ketik untuk mencari..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              onClick={(e) => e.stopPropagation()}
              autoFocus
            />
          ) : (
            <span className={selectedLabel ? 'text-slate-900' : 'text-gray-400'}>
              {selectedLabel || placeholder}
            </span>
          )}
        </div>
        <div className="flex items-center gap-1 text-gray-400">
          {selectedValue && (
            <button 
              type="button" 
              onClick={handleClear} 
              className="hover:text-gray-600 p-0.5 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors"
            >
              <span className="material-symbols-outlined text-[18px]">close</span>
            </button>
          )}
          <span className="material-symbols-outlined text-[20px] transition-transform duration-200" style={{ transform: isOpen ? 'rotate(180deg)' : 'none' }}>
            keyboard_arrow_down
          </span>
        </div>
      </div>

      {isOpen && (
        <div className="absolute z-50 w-full mt-2 bg-white border border-gray-150 rounded-xl shadow-lg max-h-60 overflow-y-auto divide-y divide-gray-50 transition-all">
          {filteredOptions.length === 0 ? (
            <div className="px-4 py-3 text-sm text-gray-400 text-center">
              Tidak ada hasil ditemukan
            </div>
          ) : (
            filteredOptions.map((option) => (
              <div
                key={option.id}
                onClick={() => handleSelect(option)}
                className={`px-4 py-3 text-sm text-slate-900 hover:bg-emerald-50 hover:text-primary cursor-pointer transition-colors flex justify-between items-center ${String(option.id) === String(selectedValue) ? 'bg-emerald-50/50 text-primary font-semibold' : ''}`}
              >
                <span>{option.name}</span>
                {option.class && (
                  <span className="text-xs text-secondary bg-slate-100 px-2 py-0.5 rounded-md font-normal">
                    {option.class}
                  </span>
                )}
              </div>
            ))
          )}
        </div>
      )}
    </div>
  );
}
