"use client";
import { PROVINCES } from "@/const/provinces";
import { useState } from "react";

interface SearchFiltersProps {
  initialProvince?: string;
  onSearch: (filters: {
    search: string;
    country: string;
    province: string;
    sortBy: "price" | "created_at";
    sortOrder: "asc" | "desc";
  }) => void;
}

const SearchFilters = ({ initialProvince, onSearch }: SearchFiltersProps) => {
  const [search, setSearch] = useState("");
  const [country, setCountry] = useState("");
  const [province, setProvince] = useState(initialProvince || "");
  const [sortBy, setSortBy] = useState<"price" | "created_at">("created_at");
  const [sortOrder, setSortOrder] = useState<"asc" | "desc">("desc");

  const handleSearch = () => {
    onSearch({ search, country, province, sortBy, sortOrder });
  };

  return (
    <div className="bg-gray-100 p-4 rounded-md mb-4 shadow-sm">
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input
          type="text"
          className="border p-2 rounded w-full"
          placeholder="Search by Title"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />

        <input
          type="text"
          className="border p-2 rounded w-full"
          placeholder="Filter by Country"
          value={country}
          onChange={(e) => setCountry(e.target.value)}
        />

        <select
          className="border p-2 rounded w-full"
          value={province}
          onChange={(e) => setProvince(e.target.value)}
        >
          <option value="">Select a Province</option>
          {PROVINCES.map((prov) => (
            <option key={prov} value={prov}>
              {prov}
            </option>
          ))}
        </select>
      </div>

      <div className="flex space-x-4 mt-4">
        <p className="text-gray-600 self-center">Sort By:</p>
        <select
          className="border p-2 rounded w-full md:w-auto"
          value={sortBy}
          onChange={(e) => setSortBy(e.target.value as "price" | "created_at")}
        >
          <option value="created_at">Date Listed</option>
          <option value="price">Price</option>
        </select>

        <p className="text-gray-600 self-center">Order:</p>
        <select
          className="border p-2 rounded w-full md:w-auto"
          value={sortOrder}
          onChange={(e) => setSortOrder(e.target.value as "asc" | "desc")}
        >
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>

        <button
          className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition w-full md:w-auto"
          onClick={handleSearch}
        >
          Search
        </button>
      </div>
    </div>
  );
};

export default SearchFilters;
