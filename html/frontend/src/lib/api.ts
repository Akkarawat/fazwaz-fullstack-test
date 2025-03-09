import axios from "axios";
import { Property } from "@/types/Property";

interface FetchPropertiesParams {
  search?: string;
  country?: string;
  province?: string;
  sortBy?: "price" | "created_at";
  sortOrder?: "asc" | "desc";
  perPage?: number;
  page?: number;
}

interface FetchPropertiesResponse {
  data: Property[];
  total: number;
  currentPage?: number;
  perPage?: number;
}

const API_BASE_URL = "http://localhost:4000/api/properties";

export const fetchProperties = async (
  params: FetchPropertiesParams
): Promise<FetchPropertiesResponse> => {
  try {
    const { data } = await axios.get<any>(API_BASE_URL, {
      params: {
        search: params.search,
        country: params.country,
        province: params.province,
        sort_by: params.sortBy,
        sort_order: params.sortOrder,
        per_page: params.perPage,
        page: params.page,
      },
    });
    const result: FetchPropertiesResponse = {
      data: data.data.map((property: any) => Property.deserialize(property)),
      total: data.total,
      currentPage: data.page,
      perPage: data.per_page,
    };
    console.log(result);
    return result;
  } catch (error) {
    console.error("Error fetching properties from API:", error);
    return {
      data: [],
      total: 0,
      currentPage: params.page,
      perPage: params.perPage,
    };
  }
};
