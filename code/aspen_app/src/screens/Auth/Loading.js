import React from 'react';
import { useQueryClient, useQuery, useQueries } from '@tanstack/react-query';
import { create } from 'apisauce';
import * as Linking from 'expo-linking';
import * as Notifications from 'expo-notifications';
import { useNavigation, useFocusEffect, useLinkTo } from '@react-navigation/native';
import { Center, Heading, Box, Spinner, VStack, Progress } from 'native-base';
import _ from 'lodash';
import { checkVersion } from 'react-native-check-version';
import { BrowseCategoryContext, LanguageContext, LibraryBranchContext, LibrarySystemContext, UserContext } from '../../context/initialContext';
import { LIBRARY, reloadBrowseCategories } from '../../util/loadLibrary';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { getBrowseCategoryListForUser, PATRON } from '../../util/loadPatron';
import { ForceLogout } from './ForceLogout';
import { UpdateAvailable } from './UpdateAvailable';
import { getTranslatedTerm, getTranslatedTermsForAllLanguages, translationsLibrary } from '../../translations/TranslationService';
import { reloadProfile } from '../../util/api/user';
import { getLibraryInfo, getLibraryLanguages } from '../../util/api/library';
import { getLocationInfo } from '../../util/api/location';
import { GLOBALS } from '../../util/globals';

const prefix = Linking.createURL('/');

Notifications.setNotificationHandler({
     handleNotification: async () => ({
          shouldShowAlert: true,
          shouldPlaySound: true,
          shouldSetBadge: false,
     }),
});

export const LoadingScreen = () => {
     const linkingUrl = Linking.useURL();
     const linkTo = useLinkTo();
     const navigation = useNavigation();
     const [loadingText, setLoadingText] = React.useState('The oldest library in the world dates from the seventh century BC.');
     const [progress, setProgress] = React.useState(0);
     const [hasUpdate, setHasUpdate] = React.useState(false);
     const [incomingUrl, setIncomingUrl] = React.useState('');
     const [hasIncomingUrlChanged, setIncomingUrlChanged] = React.useState(false);

     const { user, updateUser } = React.useContext(UserContext);
     const { library, updateLibrary } = React.useContext(LibrarySystemContext);
     const { location, updateLocation, updateScope } = React.useContext(LibraryBranchContext);
     const { category, updateBrowseCategories, updateBrowseCategoryList, updateMaxCategories } = React.useContext(BrowseCategoryContext);
     const { language, updateLanguage, updateLanguages, updateDictionary, dictionary } = React.useContext(LanguageContext);

     React.useEffect(() => {
          const responseListener = Notifications.addNotificationResponseReceivedListener((response) => {
               const url = response?.notification?.request?.content?.data?.url ?? prefix;
               if (url !== incomingUrl) {
                    console.log('Incoming url changed');
                    console.log('OLD > ' + incomingUrl);
                    console.log('NEW > ' + url);
                    setIncomingUrl(response?.notification?.request?.content?.data?.url ?? prefix);
                    setIncomingUrlChanged(true);
               } else {
                    setIncomingUrlChanged(false);
               }
          });

          return () => {
               responseListener.remove();
          };
     }, []);

     const { status: librarySystemQueryStatus, data: librarySystemQuery } = useQuery(['library_system', LIBRARY.url], () => getLibraryInfo(LIBRARY.url), {
          onSuccess: (data) => {
               setProgress(10);
               updateLibrary(data);
          },
          staleTime: 60 * 1000 * 30,
          cacheTime: 60 * 1000 * 30,
          refetchOnWindowFocus: false,
          refetchInterval: 60 * 1000 * 30,
          refetchIntervalInBackground: true,
     });

     const { status: userQueryStatus, data: userQuery } = useQuery(['user', LIBRARY.url, 'en'], () => reloadProfile(LIBRARY.url), {
          enabled: !!librarySystemQuery,
          onSuccess: (data) => {
               setProgress(30);
               updateUser(data);
               updateLanguage(data.interfaceLanguage ?? 'en');
               PATRON.language = data.interfaceLanguage ?? 'en';
          },
          staleTime: 60 * 1000 * 15,
          cacheTime: 60 * 1000 * 15,
          refetchOnWindowFocus: false,
          refetchOnMount: false,
          refetchInterval: 60 * 1000 * 15,
          refetchIntervalInBackground: true,
     });
     const { status: browseCategoryQueryStatus, data: browseCategoryQuery } = useQuery(['browse_categories', LIBRARY.url], () => reloadBrowseCategories(5, LIBRARY.url), {
          enabled: !!userQuery,
          onSuccess: (data) => {
               setProgress(40);
               updateBrowseCategories(data);
               updateMaxCategories(5);
          },
          staleTime: 60 * 1000 * 30,
          cacheTime: 60 * 1000 * 30,
          refetchOnWindowFocus: false,
          refetchOnMount: false,
     });
     const { status: browseCategoryListQueryStatus, data: browseCategoryListQuery } = useQuery(['browse_categories_list', LIBRARY.url], () => getBrowseCategoryListForUser(LIBRARY.url), {
          enabled: !!browseCategoryQuery,
          onSuccess: (data) => {
               setProgress(50);
               updateBrowseCategoryList(data);
               setLoadingText('One of the most overdue library books in the world was returned after 122 years.');
          },
          staleTime: 60 * 1000 * 30,
          cacheTime: 60 * 1000 * 30,
          refetchOnWindowFocus: false,
          refetchInterval: 60 * 1000 * 30,
          refetchIntervalInBackground: true,
     });
     const { status: languagesQueryStatus, data: languagesQuery } = useQuery(['languages', LIBRARY.url], () => getLibraryLanguages(LIBRARY.url), {
          enabled: !!browseCategoryListQuery,
          onSuccess: (data) => {
               setProgress(60);
               updateLanguages(data);
          },
          staleTime: 60 * 1000 * 30,
          cacheTime: 60 * 1000 * 30,
          refetchOnWindowFocus: false,
          refetchInterval: 60 * 1000 * 30,
          refetchIntervalInBackground: true,
     });
     const { status: libraryBranchQueryStatus, data: libraryBranchQuery } = useQuery(['library_location', LIBRARY.url, 'en'], () => getLocationInfo(LIBRARY.url), {
          enabled: !!languagesQuery,
          onSuccess: (data) => {
               setProgress(70);
               updateLocation(data);
          },
          staleTime: 60 * 1000 * 30,
          cacheTime: 60 * 1000 * 30,
          refetchOnWindowFocus: false,
          refetchInterval: 60 * 1000 * 30,
          refetchIntervalInBackground: true,
     });

     const { status: translationsQueryStatus, data: translationsQuery } = useQuery(['translations', LIBRARY.url], () => getTranslatedTermsForAllLanguages(languagesQuery, LIBRARY.url), {
          enabled: !!libraryBranchQuery,
          onSuccess: (data) => {
               setProgress(90);
               updateDictionary(translationsLibrary);
               return true;
          },
          staleTime: 60 * 1000 * 30,
          cacheTime: 60 * 1000 * 30,
          refetchOnWindowFocus: false,
          refetchInterval: 60 * 1000 * 30,
          refetchIntervalInBackground: true,
     });

     if (librarySystemQueryStatus === 'error' || userQueryStatus === 'error' || browseCategoryQueryStatus === 'error' || browseCategoryListQueryStatus === 'error' || languagesQueryStatus === 'error' || libraryBranchQueryStatus === 'error' || translationsQueryStatus === 'error') {
          return <ForceLogout />;
     }

     if (librarySystemQueryStatus === 'loading' || userQueryStatus === 'loading' || browseCategoryQueryStatus === 'loading' || browseCategoryListQueryStatus === 'loading' || languagesQueryStatus === 'loading' || libraryBranchQueryStatus === 'loading' || translationsQueryStatus === 'loading') {
          return (
               <Center flex={1} px="3" w="100%">
                    <Box w="90%" maxW="400">
                         <VStack>
                              <Heading pb={5} color="primary.500" fontSize="md">
                                   {loadingText}
                              </Heading>
                              <Progress size="lg" value={progress} colorScheme="primary" />
                         </VStack>
                    </Box>
               </Center>
          );
     }

     if (librarySystemQueryStatus === 'success' || userQueryStatus === 'success' || browseCategoryQueryStatus === 'success' || browseCategoryListQueryStatus === 'success' || languagesQueryStatus === 'success' || libraryBranchQueryStatus === 'success' || translationsQueryStatus === 'success') {
          if (hasIncomingUrlChanged) {
               let url = decodeURIComponent(incomingUrl).replace(/\+/g, ' ');
               url = url.replace('aspen-lida://', prefix);
               console.log('incomingUrl > ' + url);
               setIncomingUrlChanged(false);
               try {
                    console.log('Trying to open screen based on incomingUrl...');
                    Linking.openURL(url);
               } catch (e) {
                    console.log(e);
               }
          } else if (linkingUrl) {
               if (linkingUrl !== prefix && linkingUrl !== incomingUrl) {
                    setIncomingUrl(linkingUrl);
                    console.log('Updated incoming url');
                    const { hostname, path, queryParams, scheme } = Linking.parse(linkingUrl);
                    console.log('linkingUrl > ' + linkingUrl);
                    console.log(`Linked to app with hostname: ${hostname}, path: ${path}, scheme: ${scheme} and data: ${JSON.stringify(queryParams)}`);
                    try {
                         if (scheme !== 'exp') {
                              console.log('Trying to open screen based on linkingUrl...');
                              const url = linkingUrl.replace('aspen-lida://', prefix);
                              console.log('url > ' + url);
                              linkTo('/' + url);
                         } else {
                              if (path) {
                                   console.log('Trying to open screen based on linkingUrl to Expo app...');
                                   let url = '/' + path;
                                   if (!_.isEmpty(queryParams)) {
                                        const params = new URLSearchParams(queryParams);
                                        const str = params.toString();
                                        url = url + '?' + str + '&url=' + library.baseUrl;
                                   }
                                   console.log('url > ' + url);
                                   console.log('linkingUrl > ' + linkingUrl);
                                   linkTo('/' + url);
                              }
                         }
                    } catch (e) {
                         console.log(e);
                    }
               }
          }

          navigation.navigate('DrawerStack', {
               user: user,
               library: library,
               location: location,
          });
     }
};

async function checkStoreVersion() {
     try {
          const version = await checkVersion({
               bundleId: GLOBALS.bundleId,
               currentVersion: GLOBALS.appVersion,
          });
          if (version.needsUpdate) {
               return {
                    needsUpdate: true,
                    url: version.url,
                    latest: version.version,
               };
          }
     } catch (e) {
          console.log(e);
     }

     return {
          needsUpdate: false,
          url: null,
          latest: GLOBALS.appVersion,
     };
}

export default LoadingScreen;