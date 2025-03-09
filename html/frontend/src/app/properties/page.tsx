"use client";
import { useState, useEffect } from "react";
import { Property } from "@/types/Property";
import SearchFilters from "@/components/SearchFilters";
import PropertyCard from "@/components/PropertyCard";
import Pagination from "@/components/Pagination";
import { fetchProperties } from "@/lib/api";

const Properties = () => {
  const [properties, setProperties] = useState<Property[]>([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);

  const [filters, setFilters] = useState({
    search: "",
    country: "",
    province: "",
    sortBy: "created_at" as "price" | "created_at",
    sortOrder: "desc" as "asc" | "desc",
  });

  const perPage = 25;
  const totalPages = Math.ceil(total / perPage);

  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      try {
        const { data, total } = await fetchProperties({
          perPage: perPage,
          page: currentPage,
          ...filters,
        });
        setProperties(data);
        setTotal(total);
      } catch (error) {
        console.error("Error fetching properties:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [currentPage, filters]);

  const handleSearch = (newFilters: typeof filters) => {
    setFilters(newFilters);
    setCurrentPage(1);
  };

  return (
    <div className="max-w-5xl mx-auto p-6">
      <h1 className="text-2xl font-semibold mb-4">Search Properties</h1>

      <SearchFilters onSearch={handleSearch} />

      <Pagination
        isLoading={loading}
        currentPage={currentPage}
        perPage={perPage}
        total={total}
        onPageChange={setCurrentPage}
      />

      {loading ? (
        <p>Loading...</p>
      ) : (
        <div className="grid grid-cols-1 gap-4 mt-4">
          {properties.map((property) => (
            <PropertyCard key={property.id} property={property} />
          ))}
        </div>
      )}

      <Pagination
        isLoading={loading}
        currentPage={currentPage}
        perPage={perPage}
        total={total}
        onPageChange={setCurrentPage}
      />
    </div>
  );
};

export default Properties;
