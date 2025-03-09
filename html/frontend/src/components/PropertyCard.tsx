import { Property } from "@/types/Property";

const PropertyCard = ({ property }: { property: Property }) => {
  return (
    <div className="border p-4 rounded-lg shadow-md bg-white">
      <h2 className="text-lg font-semibold">{property.title}</h2>

      <div className="w-full my-2">
        <img
          src={property.photos.thumb}
          alt="Property"
          className="block sm:hidden w-full h-auto rounded"
        />
        <img
          src={property.photos.search}
          alt="Property"
          className="hidden sm:block md:hidden w-full h-auto rounded"
        />
        <img
          src={property.photos.full}
          alt="Property"
          className="hidden md:block w-full h-auto rounded"
        />
      </div>

      <p className="text-green-600 font-semibold text-lg">
        {property.currencySymbol}
        {property.price}
      </p>

      <p className="text-gray-600">
        {property.geo.street}, {property.geo.province}, {property.geo.country}
      </p>

      <p className="text-sm">🛏 {property.bathroomsCount} Bedrooms</p>
      <p className="text-sm">🛁 {property.bathroomsCount} Bathrooms</p>
      <p className="text-sm">
        📏 {property.area} {property.areaType}
      </p>

      <p className="mt-2 text-gray-700">{property.description}</p>

      <p className="text-xs text-gray-400">
        Listed: {new Date(property.createdAt).toLocaleDateString()} | Updated:{" "}
        {new Date(property.updatedAt).toLocaleDateString()}
      </p>
    </div>
  );
};

export default PropertyCard;
