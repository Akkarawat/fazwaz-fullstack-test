"use client";
import PropertiesPage from "@/components/pages/PropertyListPage";
import { PROVINCES } from "@/const/provinces";
import { notFound, useParams } from "next/navigation";

export default function PropertyInProvincePage() {
  const { province } = useParams<{ province: string }>();

  const formattedProvince = province
    ? province.replace(/_/g, " ").replace(/\b\w/g, (char) => char.toUpperCase())
    : "";
  if (formattedProvince !== "" && !PROVINCES.includes(formattedProvince)) {
    notFound();
  }

  return <PropertiesPage province={formattedProvince} />;
}
