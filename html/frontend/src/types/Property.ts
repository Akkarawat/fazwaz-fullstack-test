export class Property {
  id: number;
  title: string;
  description: string;
  forSale: boolean;
  forRent: boolean;
  sold: boolean;
  price: string;
  currency: string;
  currencySymbol: string;
  propertyType: string;
  bedroomsCount: number;
  bathroomsCount: number;
  area: string;
  areaType: string;
  createdAt: string;
  updatedAt: string;
  geo: {
    country: string;
    province: string;
    street: string;
  };
  photos: {
    thumb: string;
    search: string;
    full: string;
  };

  constructor(data: Partial<Property>) {
    this.id = data.id ?? 0;
    this.title = data.title ?? "";
    this.description = data.description ?? "";
    this.forSale = data.forSale ?? false;
    this.forRent = data.forRent ?? false;
    this.sold = data.sold ?? false;
    this.price = data.price ?? "0.00";
    this.currency = data.currency ?? "";
    this.currencySymbol = data.currencySymbol ?? "";
    this.propertyType = data.propertyType ?? "";
    this.bedroomsCount = data.bedroomsCount ?? 0;
    this.bathroomsCount = data.bathroomsCount ?? 0;
    this.area = data.area ?? "0.00";
    this.areaType = data.areaType ?? "";
    this.createdAt = data.createdAt ?? "";
    this.updatedAt = data.updatedAt ?? "";
    this.geo = data.geo ?? { country: "", province: "", street: "" };
    this.photos = data.photos ?? { thumb: "", search: "", full: "" };
  }

  static deserialize(json: any): Property {
    return new Property({
      id: json.id,
      title: json.title,
      description: json.description,
      forSale: json.for_sale,
      forRent: json.for_rent,
      sold: json.sold,
      price: json.price,
      currency: json.currency,
      currencySymbol: json.currency_symbol,
      propertyType: json.property_type,
      bedroomsCount: json.bedrooms_count,
      bathroomsCount: json.bathrooms_count,
      area: json.area,
      areaType: json.area_type,
      createdAt: json.created_at,
      updatedAt: json.updated_at,
      geo: {
        country: json.geo?.country,
        province: json.geo?.province,
        street: json.geo?.street,
      },
      photos: {
        thumb: json.photos?.thumb,
        search: json.photos?.search,
        full: json.photos?.full,
      },
    });
  }
}
