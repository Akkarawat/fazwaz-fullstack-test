"use client";

interface PaginationProps {
  isLoading: boolean;
  currentPage: number;
  perPage: number;
  total: number;
  onPageChange: (newPage: number) => void;
}

const Pagination = ({
  isLoading,
  currentPage,
  perPage,
  total,
  onPageChange,
}: PaginationProps) => {
  const totalPages = Math.ceil(total / perPage);
  const start = total === 0 ? 0 : (currentPage - 1) * perPage + 1;
  const end = Math.min(currentPage * perPage, total);

  if (isLoading) {
    return <></>;
  }

  return (
    <div className="flex flex-col md:flex-row md:justify-between items-center mt-4 text-gray-700">
      <button
        className="border px-4 py-2 rounded disabled:opacity-50"
        disabled={currentPage === 1}
        onClick={() => onPageChange(currentPage - 1)}
      >
        Previous
      </button>
      <p className="text-sm md:text-base">
        {total > 0
          ? `Showing results ${start}-${end} of ${total}`
          : "No results found"}
      </p>
      <button
        className="border px-4 py-2 rounded disabled:opacity-50"
        disabled={currentPage >= totalPages}
        onClick={() => onPageChange(currentPage + 1)}
      >
        Next
      </button>
    </div>
  );
};

export default Pagination;
