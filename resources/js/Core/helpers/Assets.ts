import { illustrationsSet } from "@/Layouts/default-layout/config/helper";
import { useThemeStore } from "@/Stores/theme";

export const getIllustrationsPath = (illustrationName: string): string => {
  const extension = illustrationName.substring(
    illustrationName.lastIndexOf("."),
    illustrationName.length
  );
  const illustration =
    useThemeStore().mode == "dark"
      ? `${illustrationName.substring(
          0,
          illustrationName.lastIndexOf(".")
        )}-dark`
      : illustrationName.substring(0, illustrationName.lastIndexOf("."));
  return (
    import.meta.env.BASE_URL +
    `media/illustrations/${illustrationsSet.value}/${illustration}${extension}`
  );
};

export const getAssetPath = (path: string): string => {
  return import.meta.env.VITE_APP_URL + path;
};
